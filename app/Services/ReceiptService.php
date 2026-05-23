<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReceiptService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

    private string $geminiApiKey;
    private string $geminiModel;
    private string $geminiBaseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey       = config('services.openrouter.api_key', '');
        $this->model        = config('services.openrouter.receipt_model', 'google/gemma-3-12b-it');
        $this->geminiApiKey = config('services.gemini.api_key', '');
        $this->geminiModel  = config('services.gemini.model', 'gemini-2.5-flash-lite');
    }

    public function parseReceipt(string $imagePath, array $userCategories = [], bool $isPremium = false): array
    {
        $imageData = base64_encode(file_get_contents($imagePath));

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer'  => config('app.url', 'https://moma.app'),
                'X-Title'       => 'MOMA Finance',
            ])
            ->post($this->baseUrl, [
                'model'           => $this->model,
                'messages'        => [
                    [
                        'role'    => 'user',
                        'content' => [
                            [
                                'type'      => 'image_url',
                                'image_url' => ['url' => 'data:image/jpeg;base64,' . $imageData],
                            ],
                            [
                                'type' => 'text',
                                'text' => $this->buildPrompt($userCategories),
                            ],
                        ],
                    ],
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature'     => 0.1,
                'provider'        => [
                    'order'           => ['deepinfra/bf16'],
                    'allow_fallbacks' => false,
                ],
            ]);

        if (! $response->successful()) {
            $status = $response->status();
            Log::error('OpenRouter Vision error', ['status' => $status, 'body' => $response->body()]);

            if ($isPremium && in_array($status, [429, 503])) {
                return $this->parseWithGemini($imagePath, $userCategories);
            }

            throw new \RuntimeException('Gagal memproses gambar struk. Coba lagi.');
        }

        $rawText = $response->json('choices.0.message.content');

        if (! $rawText) {
            if ($isPremium) {
                return $this->parseWithGemini($imagePath, $userCategories);
            }
            throw new \RuntimeException('AI tidak dapat membaca struk ini.');
        }

        Log::info('[AI Receipt] OpenRouter response', [
            'model'    => $this->model,
            'response' => $rawText,
        ]);

        return $this->processResponse($rawText);
    }

    private function parseWithGemini(string $imagePath, array $userCategories): array
    {
        $imageData = base64_encode(file_get_contents($imagePath));

        $response = Http::timeout(60)->post(
            "{$this->geminiBaseUrl}/{$this->geminiModel}:generateContent?key={$this->geminiApiKey}",
            [
                'contents'         => [
                    [
                        'parts' => [
                            [
                                'inlineData' => [
                                    'mimeType' => 'image/jpeg',
                                    'data'     => $imageData,
                                ],
                            ],
                            ['text' => $this->buildPrompt($userCategories)],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'temperature'      => 0.1,
                ],
            ]
        );

        if (! $response->successful()) {
            Log::error('Gemini fallback Vision error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Gagal memproses gambar struk. Coba lagi.');
        }

        $rawText = $response->json('candidates.0.content.parts.0.text');

        if (! $rawText) {
            throw new \RuntimeException('AI tidak dapat membaca struk ini.');
        }

        Log::info('[AI Receipt] Gemini fallback response', [
            'model'    => $this->geminiModel,
            'response' => $rawText,
        ]);

        return $this->processResponse($rawText);
    }

    private function processResponse(string $rawText): array
    {
        $parsed = json_decode($this->cleanJson($rawText), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Gambar tidak dapat dibaca sebagai struk 🧾 Pastikan foto jelas dan berupa struk, nota, atau bukti pembayaran.');
        }

        if (empty($parsed)) {
            throw new \RuntimeException('Ini bukan struk belanja 🧾 Pastikan foto berupa struk, nota, invoice, atau bukti pembayaran ya.');
        }

        if (isset($parsed['type'])) {
            $parsed = [$parsed];
        }

        if (isset($parsed['transactions']) && is_array($parsed['transactions'])) {
            $parsed = $parsed['transactions'];
        }

        if (! is_array($parsed)) {
            throw new \RuntimeException('Ini bukan struk belanja 🧾 Pastikan foto berupa struk, nota, invoice, atau bukti pembayaran ya.');
        }

        foreach ($parsed as &$item) {
            if (! isset($item['type'], $item['amount'])) {
                throw new \RuntimeException('Gambar tidak dapat dibaca sebagai struk 🧾 Pastikan foto jelas dan berupa struk, nota, atau bukti pembayaran.');
            }
            $item['amount'] = max(0, (float) $item['amount']);
        }

        return $parsed;
    }

    private function cleanJson(string $text): string
    {
        $text = trim($text);
        if (str_starts_with($text, '```')) {
            $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
            $text = preg_replace('/\s*```$/', '', $text);
        }
        return trim($text);
    }

    private function buildPrompt(array $userCategories = []): string
    {
        $userCategorySection = '';
        if (!empty($userCategories)) {
            $lines = [];
            foreach ($userCategories as $cat) {
                $typeLabel = match($cat['type'] ?? '') {
                    'expense' => 'expense',
                    'income'  => 'income',
                    'both'    => 'expense & income',
                    default   => $cat['type'] ?? '',
                };
                $subsText = !empty($cat['subs'])
                    ? ' | subs: ' . implode(', ', $cat['subs'])
                    : '';
                $lines[] = "  - \"{$cat['name']}\"{$subsText} [{$typeLabel}]";
            }
            $userCategorySection = "\n\nKATEGORI USER [PRIORITAS — periksa SEBELUM default]:\n"
                . implode("\n", $lines)
                . "\nWAJIB pakai nama PERSIS jika cocok. Default hanya jika tidak ada yang cocok.";
        }

        return <<<PROMPT
Parser struk keuangan Indonesia.$userCategorySection

VALIDASI WAJIB — periksa SEBELUM mengekstrak:
Gambar HARUS berupa struk/nota/invoice/kwitansi/bukti pembayaran (kasir, toko, restoran, marketplace, transfer bank, QRIS, dsb).
Jika gambar adalah foto biasa, produk, makanan, orang, tangkapan layar non-keuangan, dokumen bukan struk, atau gambar yang hanya kebetulan ada angka → kembalikan [] langsung.

ATURAN (output: JSON array valid, tanpa markdown):
- Angka IDR, asumsikan IDR jika tidak ada simbol mata uang
- type: "expense" (pembelian/pembayaran) | "income" (penerimaan uang)
- amount: gunakan TOTAL keseluruhan, bukan item individual (kecuali tidak ada total)
- title: nama merchant/deskripsi singkat, maks 50 karakter
- wallet_hint: null | to_wallet_hint: null
- description: nomor transaksi/catatan penting, null jika tidak ada
- category_name (pilih PERSIS):
  expense→ "Makanan & Minuman"|"Transportasi"|"Kebutuhan Rumah Tangga"|"Keuangan & Tagihan"|"Kesehatan"|"Pendidikan"|"Belanja Pribadi"|"Hiburan"|"Sosial & Donasi"|"Keluarga & Anak"|"Lainnya"
  income→ "Pendapatan"|"Pekerjaan & Bisnis"
- category_icon: emoji sesuai kategori

OUTPUT: [{"type":"expense","title":"Nama Merchant","amount":50000,"category_name":"Makanan & Minuman","category_icon":"🍽️","wallet_hint":null,"to_wallet_hint":null,"description":null}]
PROMPT;
    }
}
