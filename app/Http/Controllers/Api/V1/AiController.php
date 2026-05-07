<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use App\Services\ReceiptService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AiController extends Controller
{
    public function __construct(
        private readonly AiService      $aiService,
        private readonly ReceiptService $receiptService,
    ) {}

    // ── Text / Voice ──────────────────────────────────────────────────────────

    public function parseTransaction(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        try {
            $result = $this->aiService->parseTransaction($request->string('message'));

            return response()->json([
                'success' => true,
                'data'    => $result,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // ── Receipt scan ──────────────────────────────────────────────────────────

    public function scanReceipt(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5120', // max 5 MB
        ]);

        $storedPath = null;

        try {
            // Store in private temp location — never served publicly
            $storedPath = $request->file('image')
                ->store('temp/receipts', 'local');

            $fullPath = Storage::disk('local')->path($storedPath);

            $result = $this->receiptService->parseReceipt($fullPath);

            return response()->json([
                'success' => true,
                'data'    => $result,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } finally {
            // Always delete temp file — image is never stored permanently
            if ($storedPath && Storage::disk('local')->exists($storedPath)) {
                Storage::disk('local')->delete($storedPath);
            }
        }
    }
}
