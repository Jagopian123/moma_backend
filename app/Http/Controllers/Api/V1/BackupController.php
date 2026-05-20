<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserBackup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    /**
     * Upload / update backup data milik user yang sedang login.
     *
     * Mendukung dua format:
     *   - compressed = false (legacy) : data adalah JSON string mentah
     *   - compressed = true           : data adalah base64(gzip(JSON))
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'data'         => 'required|string',
            'backed_up_at' => 'required|string',
            'compressed'   => 'boolean',
        ]);

        $isCompressed = $request->boolean('compressed', false);
        $rawData      = $request->input('data');

        if ($isCompressed) {
            // Validasi: harus bisa di-decode base64 dan di-decompress gzip
            $decoded = base64_decode($rawData, true);
            if ($decoded === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid (bukan base64)',
                ], 422);
            }

            $decompressed = @gzdecode($decoded);
            if ($decompressed === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid (gagal decompress)',
                ], 422);
            }

            json_decode($decompressed);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data backup tidak valid (bukan JSON setelah decompress)',
                ], 422);
            }
        } else {
            // Legacy: validasi JSON mentah
            json_decode($rawData);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data backup tidak valid (bukan JSON)',
                ], 422);
            }
        }

        UserBackup::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'data'          => $rawData,
                'is_compressed' => $isCompressed,
                'backed_up_at'  => $request->input('backed_up_at'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Backup berhasil disimpan',
        ]);
    }

    /**
     * Ambil backup terakhir milik user yang sedang login.
     * Response menyertakan flag is_compressed agar client tahu cara memprosesnya.
     */
    public function show(Request $request): JsonResponse
    {
        $backup = UserBackup::where('user_id', $request->user()->id)->first();

        if (! $backup) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada backup',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'data'          => $backup->data,
                'is_compressed' => $backup->is_compressed,
                'backed_up_at'  => $backup->backed_up_at->toIso8601String(),
            ],
        ]);
    }
}
