<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'message'        => 'required|string|max:500',
            'user_categories' => 'nullable|array',
        ]);

        /** @var User $user */
        $user = $request->user();

        if (!$user->canUseAi()) {
            return response()->json([
                'success'           => false,
                'message'           => 'Kredit AI harian habis. Upgrade ke Premium untuk akses unlimited.',
                'credits_remaining' => 0,
            ], 429);
        }

        try {
            $userCategories = $request->input('user_categories', []);
            $result = $this->aiService->parseTransaction($request->string('message'), $userCategories);

            $user->incrementAiCredits();

            return response()->json([
                'success'           => true,
                'data'              => $result,
                'credits_remaining' => $user->remainingAiCredits(),
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
            'image'           => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'user_categories' => 'nullable|string',
        ]);

        /** @var User $user */
        $user = $request->user();

        if (!$user->canUseAi()) {
            return response()->json([
                'success'           => false,
                'message'           => 'Kredit AI harian habis. Upgrade ke Premium untuk akses unlimited.',
                'credits_remaining' => 0,
            ], 429);
        }

        $storedPath = null;

        try {
            $storedPath = $request->file('image')
                ->store('temp/receipts', 'local');

            $fullPath = Storage::disk('local')->path($storedPath);

            $rawCategories = $request->input('user_categories', '[]');
            $userCategories = json_decode($rawCategories, true) ?? [];

            $result = $this->receiptService->parseReceipt($fullPath, $userCategories);

            $user->incrementAiCredits();

            return response()->json([
                'success'           => true,
                'data'              => $result,
                'credits_remaining' => $user->remainingAiCredits(),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } finally {
            if ($storedPath && Storage::disk('local')->exists($storedPath)) {
                Storage::disk('local')->delete($storedPath);
            }
        }
    }

    // ── Credit status ─────────────────────────────────────────────────────────

    public function credits(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data'    => [
                'is_premium'        => $user->isPremium(),
                'credits_remaining' => $user->remainingAiCredits(),
                'daily_limit'       => User::AI_FREE_DAILY_LIMIT,
            ],
        ]);
    }
}
