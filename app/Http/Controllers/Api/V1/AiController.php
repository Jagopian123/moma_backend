<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AiService;
use App\Services\ReceiptService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
            'message'         => 'required|string|max:200',
            'user_categories' => 'nullable|array',
            'user_wallets'    => 'nullable|array',
        ]);

        /** @var User $user */
        $user = $request->user();

        if (!$user->canUseAi()) {
            return response()->json([
                'success'           => false,
                'message'           => 'Kredit AI bulanan kamu sudah habis 😔 Upgrade ke Premium untuk catat AI tanpa batas!',
                'credits_remaining' => 0,
            ], 429);
        }

        try {
            $userCategories = $request->input('user_categories', []);
            $userWallets    = $request->input('user_wallets', []);
            $result = $this->aiService->parseTransaction($request->string('message'), $userCategories, $userWallets, $user->isPremium());

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
                'message'           => 'Kredit AI bulanan kamu sudah habis 😔 Upgrade ke Premium untuk catat AI tanpa batas!',
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

            $result = $this->receiptService->parseReceipt($fullPath, $userCategories, $user->isPremium());

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
                'monthly_limit'     => User::AI_FREE_MONTHLY_LIMIT,
            ],
        ]);
    }

    // ── Ad reward — max 1x per hari per user ──────────────────────────────────

    public function rewardCredits(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->isPremium()) {
            return response()->json([
                'success'           => true,
                'credits_remaining' => -1,
                'message'           => 'Kamu sudah Premium, kredit tidak terbatas!',
            ]);
        }

        $key = "ad_reward:{$user->id}";

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $hours   = ceil($seconds / 3600);
            return response()->json([
                'success' => false,
                'message' => "Sudah 3x nonton iklan hari ini. Kembali lagi besok!",
            ], 429);
        }

        RateLimiter::hit($key, 60 * 60 * 24);

        $remaining = $user->rewardAiCredits(5);

        return response()->json([
            'success'           => true,
            'credits_remaining' => $remaining,
            'message'           => '+3 kredit AI berhasil ditambahkan!',
        ]);
    }
}
