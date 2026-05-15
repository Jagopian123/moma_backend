<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReceiptService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
        $this->model  = config('services.gemini.model', 'gemini-2.5-flash-lite');
    }

    /**
     * Parse a receipt image and return an array of transactions.
     * The image is base64-encoded server-side; Flutter only sends multipart.
     */
    public function parseReceipt(string $imagePath, array $userCategories = []): array
    {
        $imageData = base64_encode(file_get_contents($imagePath));

        $response = Http::timeout(60)->post(
            "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}",
            [
                'contents' => [
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
            Log::error('Gemini Vision error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Gagal memproses gambar struk. Coba lagi.');
        }

        $jsonText = $response->json('candidates.0.content.parts.0.text');

        if (! $jsonText) {
            throw new \RuntimeException('AI tidak dapat membaca struk ini.');
        }

        $parsed = json_decode($jsonText, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('AI mengembalikan format yang tidak valid.');
        }

        // Return empty array if AI found nothing (e.g. not a receipt)
        if (empty($parsed)) {
            throw new \RuntimeException('Tidak ada transaksi yang dapat dibaca dari gambar ini.');
        }

        // Wrap single object for consistency
        if (isset($parsed['type'])) {
            $parsed = [$parsed];
        }

        if (! is_array($parsed)) {
            throw new \RuntimeException('Format response tidak valid.');
        }

        foreach ($parsed as &$item) {
            if (! isset($item['type'], $item['amount'])) {
                throw new \RuntimeException('Format data transaksi tidak valid.');
            }
            $item['amount'] = max(0, (float) $item['amount']);
        }

        return $parsed;
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
Parser struk keuangan Indonesia. Ekstrak semua transaksi dari gambar.$userCategorySection

ATURAN (output: JSON array valid, tanpa markdown):
- Jika tidak ada struk jelas dalam gambar, kembalikan []
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
