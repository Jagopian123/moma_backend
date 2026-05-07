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
    public function parseReceipt(string $imagePath): array
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
                            ['text' => $this->buildPrompt()],
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

    private function buildPrompt(): string
    {
        return <<<'PROMPT'
Kamu adalah parser transaksi keuangan untuk pengguna Indonesia. Baca gambar struk/nota/bukti pembayaran ini dan ekstrak semua transaksi.

ATURAN PENTING:
- Kembalikan HANYA JSON array valid, tanpa penjelasan atau markdown
- Jika tidak ada struk yang jelas dalam gambar, kembalikan []
- Jumlah dalam angka IDR (Rupiah). Jika tidak ada simbol mata uang, asumsikan IDR
- type: "expense" untuk pembelian/pembayaran, "income" untuk penerimaan uang
- Gunakan TOTAL keseluruhan sebagai amount, bukan item individual (kecuali tidak ada total)
- title: nama merchant atau deskripsi singkat struk, maks 50 karakter
- wallet_hint: null (tidak bisa diketahui dari struk)
- to_wallet_hint: null
- description: nomor transaksi / catatan penting lainnya, atau null
- category_name HARUS salah satu dari daftar ini PERSIS:
  Untuk expense: "Makanan & Minuman", "Transportasi", "Kebutuhan Rumah Tangga",
    "Keuangan & Tagihan", "Kesehatan", "Pendidikan", "Belanja Pribadi",
    "Hiburan", "Sosial & Donasi", "Keluarga & Anak", "Lainnya"
  Untuk income: "Pendapatan", "Pekerjaan & Bisnis"
- category_icon: emoji yang sesuai dengan kategori

FORMAT OUTPUT:
[
  {
    "type": "expense",
    "title": "Nama Merchant",
    "amount": 50000,
    "category_name": "Makanan & Minuman",
    "category_icon": "🍽️",
    "wallet_hint": null,
    "to_wallet_hint": null,
    "description": null
  }
]
PROMPT;
    }
}
