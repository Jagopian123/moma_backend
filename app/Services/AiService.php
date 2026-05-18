<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

    private string $geminiApiKey;
    private string $geminiModel;
    private string $geminiBaseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey      = config('services.openrouter.api_key', '');
        $this->model       = config('services.openrouter.text_model', 'mistralai/mistral-nemo');
        $this->geminiApiKey = config('services.gemini.api_key', '');
        $this->geminiModel  = config('services.gemini.model', 'gemini-2.5-flash-lite');
    }

    public function parseTransaction(string $message, array $userCategories = [], array $userWallets = [], bool $isPremium = false): array
    {
        $prompt = $this->buildPrompt($message, $userCategories, $userWallets);

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer'  => config('app.url', 'https://moma.app'),
                'X-Title'       => 'MOMA Finance',
            ])
            ->post($this->baseUrl, [
                'model'       => $this->model,
                'messages'    => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.1,
                'provider'    => [
                    'order'           => ['dekallm/fp8', 'deepinfra/fp8'],
                    'allow_fallbacks' => false,
                ],
            ]);

        if (! $response->successful()) {
            $status = $response->status();
            Log::error('OpenRouter AI error', ['status' => $status, 'body' => $response->body()]);

            if ($isPremium && in_array($status, [429, 503])) {
                return $this->parseWithGemini($prompt);
            }

            throw new \RuntimeException('Gagal menghubungi AI. Coba lagi.');
        }

        $rawText = $response->json('choices.0.message.content');

        if (! $rawText) {
            if ($isPremium) {
                return $this->parseWithGemini($prompt);
            }
            throw new \RuntimeException('AI tidak dapat memproses pesan ini.');
        }

        return $this->processResponse($rawText);
    }

    private function parseWithGemini(string $prompt): array
    {
        $response = Http::timeout(30)->post(
            "{$this->geminiBaseUrl}/{$this->geminiModel}:generateContent?key={$this->geminiApiKey}",
            [
                'contents'         => [
                    ['parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'temperature'      => 0.1,
                ],
            ]
        );

        if (! $response->successful()) {
            Log::error('Gemini fallback AI error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Gagal menghubungi AI. Coba lagi.');
        }

        $rawText = $response->json('candidates.0.content.parts.0.text');

        if (! $rawText) {
            throw new \RuntimeException('AI tidak dapat memproses pesan ini.');
        }

        return $this->processResponse($rawText);
    }

    private function processResponse(string $rawText): array
    {
        $friendlyMsg = 'Hmm, saya kurang paham 😅 Coba ceritakan transaksinya, misalnya: "beli kopi 25k cash" atau "gajian 5 juta BCA".';

        $parsed = json_decode($this->cleanJson($rawText), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException($friendlyMsg);
        }

        if (isset($parsed['type'])) {
            $parsed = [$parsed];
        }

        if (isset($parsed['transactions']) && is_array($parsed['transactions'])) {
            $parsed = $parsed['transactions'];
        }

        if (! is_array($parsed) || empty($parsed)) {
            throw new \RuntimeException($friendlyMsg);
        }

        foreach ($parsed as &$item) {
            if (! isset($item['type']) || ! array_key_exists('amount', $item)) {
                throw new \RuntimeException($friendlyMsg);
            }
            $item['amount'] = max(0, (float) ($item['amount'] ?? 0));
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

    private function buildPrompt(string $message, array $userCategories = [], array $userWallets = []): string
    {
        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        $walletSection = '';
        if (!empty($userWallets)) {
            $names = implode(', ', array_map(fn($w) => "\"{$w['name']}\"", $userWallets));
            $walletSection = "\n\nDOMPET USER: {$names}"
                . "\nJika user menyebut dompet, WAJIB gunakan nama PERSIS dari daftar ini jika cocok.";
        }

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
Parser transaksi keuangan Indonesia. Hari ini: $today.$walletSection$userCategorySection

ATURAN (output: JSON array valid, selalu array, tanpa markdown):
- Angka IDR: "k"/"ribu"=×1000, "jt"/"juta"=×1.000.000
- type: "expense"|"income"|"transfer"
- title: maks 50 karakter
- wallet_hint: gunakan nama PERSIS dari DOMPET USER di atas jika cocok, atau nama umum (cash/bca/mandiri/gopay/ovo/dana/dll), null jika tidak disebutkan
- to_wallet_hint: dompet tujuan transfer (gunakan nama PERSIS dari DOMPET USER jika cocok), null jika bukan transfer
- description: catatan penting, null jika tidak ada
- category_name (pilih PERSIS):
  expense→ "Makanan & Minuman"|"Transportasi"|"Kebutuhan Rumah Tangga"|"Keuangan & Tagihan"|"Kesehatan"|"Pendidikan"|"Belanja Pribadi"|"Hiburan"|"Sosial & Donasi"|"Keluarga & Anak"|"Lainnya"
  income→ "Pendapatan"|"Pekerjaan & Bisnis"
  keduanya→ "Tabungan & Investasi" | transfer→ "Transfer"
- category_icon: emoji sesuai kategori
- date: YYYY-MM-DD jika ada ("kemarin"=hari-1, "3 hari lalu"=hari-3, "2 Mei"=tahun ini), null jika tidak disebutkan

CONTOH INPUT: "makan siang 30k cash kemarin, ngopi 68k bri"
CONTOH OUTPUT: [{"type":"expense","title":"Makan Siang","amount":30000,"category_name":"Makanan & Minuman","category_icon":"🍽️","wallet_hint":"cash","to_wallet_hint":null,"description":null,"date":"$yesterday"},{"type":"expense","title":"Ngopi","amount":68000,"category_name":"Makanan & Minuman","category_icon":"☕","wallet_hint":"bri","to_wallet_hint":null,"description":null,"date":null}]

INPUT: $message
PROMPT;
    }
}
