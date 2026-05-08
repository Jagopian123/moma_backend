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
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'data'         => 'required|string',
            'backed_up_at' => 'required|string',
        ]);

        // Pastikan data adalah JSON valid
        json_decode($request->input('data'));
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'success' => false,
                'message' => 'Data backup tidak valid (bukan JSON)',
            ], 422);
        }

        UserBackup::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'data'         => $request->input('data'),
                'backed_up_at' => $request->input('backed_up_at'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Backup berhasil disimpan',
        ]);
    }

    /**
     * Ambil backup terakhir milik user yang sedang login.
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
                'data'         => $backup->data,
                'backed_up_at' => $backup->backed_up_at->toIso8601String(),
            ],
        ]);
    }
}
