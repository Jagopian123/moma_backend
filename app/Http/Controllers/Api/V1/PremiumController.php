<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    private const PRODUCTS = [
        'moma_premium_monthly' => 30,
        'moma_premium_yearly'  => 365,
    ];

    public function status(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data'    => [
                'is_premium'         => $user->isPremium(),
                'premium_expires_at' => $user->premium_expires_at,
                'credits_remaining'  => $user->remainingAiCredits(),
                'daily_limit'        => User::AI_FREE_DAILY_LIMIT,
                'features'           => $this->getFeatures($user->isPremium()),
            ],
        ]);
    }

    public function plans(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => [
                [
                    'id'          => 'moma_premium_monthly',
                    'name'        => 'Bulanan',
                    'price'       => 29000,
                    'duration'    => 30,
                    'description' => 'Akses semua fitur premium selama 1 bulan',
                ],
                [
                    'id'          => 'moma_premium_yearly',
                    'name'        => 'Tahunan',
                    'price'       => 249000,
                    'duration'    => 365,
                    'description' => 'Hemat 28% dibanding bulanan',
                    'is_popular'  => true,
                ],
            ],
        ]);
    }

    public function activate(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_token' => 'required|string',
            'product_id'     => 'required|in:' . implode(',', array_keys(self::PRODUCTS)),
        ]);

        /** @var User $user */
        $user       = $request->user();
        $productId  = $request->input('product_id');
        $token      = $request->input('purchase_token');
        $days       = self::PRODUCTS[$productId];

        // Reject duplicate token replay
        if ($user->last_purchase_token === $token) {
            return response()->json([
                'success' => true,
                'message' => 'Langganan sudah aktif.',
                'data'    => $this->premiumData($user),
            ]);
        }

        // If already premium and not expired, extend from current expiry
        $base = ($user->isPremium() && $user->premium_expires_at !== null)
            ? $user->premium_expires_at
            : now();

        $user->update([
            'is_premium'          => true,
            'premium_expires_at'  => $base->addDays($days),
            'last_purchase_token' => $token,
        ]);

        $user->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Premium berhasil diaktifkan!',
            'data'    => $this->premiumData($user),
        ]);
    }

    private function premiumData(User $user): array
    {
        return [
            'is_premium'         => $user->isPremium(),
            'premium_expires_at' => $user->premium_expires_at,
            'credits_remaining'  => $user->remainingAiCredits(),
            'features'           => $this->getFeatures(true),
        ];
    }

    private function getFeatures(bool $isPremium): array
    {
        $free = [
            'ai_credits_per_day' => User::AI_FREE_DAILY_LIMIT,
            'ai_unlimited'       => false,
        ];

        $premium = [
            'ai_credits_per_day' => -1,
            'ai_unlimited'       => true,
        ];

        return $isPremium ? $premium : $free;
    }
}
