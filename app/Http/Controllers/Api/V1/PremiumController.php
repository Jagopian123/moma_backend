<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data'    => [
                'is_premium'         => $user->isPremium(),
                'premium_expires_at' => $user->premium_expires_at,
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
                    'id'          => 'monthly',
                    'name'        => 'Bulanan',
                    'price'       => 29000,
                    'duration'    => 30,
                    'description' => 'Akses semua fitur premium selama 1 bulan',
                ],
                [
                    'id'          => 'yearly',
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
            'plan_id'       => 'required|in:monthly,yearly',
            'payment_token' => 'required|string',
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Fitur pembayaran belum tersedia',
        ], 503);
    }

    private function getFeatures(bool $isPremium): array
    {
        $free = [
            'max_wallets'    => 3,
            'max_budgets'    => 5,
            'max_plans'      => 3,
            'export_data'    => false,
            'backup_cloud'   => false,
            'multi_currency' => false,
        ];

        $premium = [
            'max_wallets'    => -1,
            'max_budgets'    => -1,
            'max_plans'      => -1,
            'export_data'    => true,
            'backup_cloud'   => true,
            'multi_currency' => true,
        ];

        return $isPremium ? $premium : $free;
    }
}