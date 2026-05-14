<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
        $this->model  = config('services.gemini.model', 'gemini-2.5-flash-lite');
    }

    public function parseTransaction(string $message): array
    {
        $response = Http::timeout(30)->post(
            "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}",
            [
                'contents' => [
                    ['parts' => [['text' => $this->buildPrompt($message)]]],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'temperature'      => 0.1,
                ],
            ]
        );

        if (! $response->successful()) {
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Gagal menghubungi AI. Coba lagi.');
        }

        $jsonText = $response->json('candidates.0.content.parts.0.text');

        if (! $jsonText) {
            throw new \RuntimeException('AI tidak dapat memproses pesan ini.');
        }

        $parsed = json_decode($jsonText, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('AI mengembalikan format yang tidak valid.');
        }

        // Support single object (backward compat) — wrap in array
        if (isset($parsed['type'])) {
            $parsed = [$parsed];
        }

        if (! is_array($parsed) || empty($parsed)) {
            throw new \RuntimeException('AI mengembalikan format yang tidak valid.');
        }

        foreach ($parsed as &$item) {
            if (! isset($item['type'], $item['amount'])) {
                throw new \RuntimeException('AI mengembalikan format yang tidak valid.');
            }
            $item['amount'] = max(0, (float) $item['amount']);
        }

        return $parsed;
    }

    private function buildPrompt(string $message): string
    {
        $today = now()->toDateString(); // YYYY-MM-DD
        return <<<PROMPT
Kamu adalah parser transaksi keuangan untuk pengguna Indonesia. Ubah input teks berikut menjadi JSON array berisi SEMUA transaksi yang disebutkan.

Hari ini: $today

ATURAN PENTING:
- Kembalikan HANYA JSON array valid (selalu array, meskipun hanya 1 transaksi), tanpa penjelasan atau markdown
- Jumlah dalam angka IDR (Rupiah). "k" atau "ribu" = ×1000, "jt" atau "juta" = ×1.000.000
- type harus salah satu: "expense", "income", "transfer"
- wallet_hint: nama dompet sumber (contoh: "cash", "bca", "mandiri", "bri", "bni", "gopay", "ovo", "dana")
- to_wallet_hint: hanya untuk transfer, nama dompet tujuan (null jika bukan transfer)
- title: judul singkat dan deskriptif, maks 50 karakter
- category_name HARUS salah satu dari daftar berikut PERSIS:
  - Untuk expense: "Makanan & Minuman", "Transportasi", "Kebutuhan Rumah Tangga", "Keuangan & Tagihan", "Kesehatan", "Pendidikan", "Belanja Pribadi", "Hiburan", "Sosial & Donasi", "Keluarga & Anak", "Lainnya"
  - Untuk income: "Pendapatan", "Pekerjaan & Bisnis"
  - Untuk keduanya: "Tabungan & Investasi"
  - Untuk transfer: "Transfer"
- category_icon: emoji yang sesuai dengan kategori
- date: tanggal transaksi format YYYY-MM-DD. Ekstrak jika user menyebutkan tanggal/waktu (contoh: "kemarin" → hari sebelum hari ini, "tadi pagi", "3 hari lalu", "2 Mei"). Jika tidak disebutkan, kembalikan null.

CONTOH INPUT: "makan siang 30k cash kemarin, sarapan 20k dana, ngopi 68k bri 3 hari lalu"
CONTOH OUTPUT:
[
  {"type":"expense","title":"Makan Siang","amount":30000,"category_name":"Makanan & Minuman","category_icon":"🍽️","wallet_hint":"cash","to_wallet_hint":null,"description":null,"date":"2026-05-13"},
  {"type":"expense","title":"Sarapan","amount":20000,"category_name":"Makanan & Minuman","category_icon":"🍳","wallet_hint":"dana","to_wallet_hint":null,"description":null,"date":null},
  {"type":"expense","title":"Ngopi","amount":68000,"category_name":"Makanan & Minuman","category_icon":"☕","wallet_hint":"bri","to_wallet_hint":null,"description":null,"date":"2026-05-11"}
]

INPUT USER: $message
PROMPT;
    }
}
