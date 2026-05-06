<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function handleGoogleCallback(Request $request): JsonResponse
    {
        $request->validate([
            'id_token'    => 'required|string',
            'device_name' => 'nullable|string|max:255',
        ]);

        try {
            $googleResponse = Http::get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->id_token,
            ]);

            if (!$googleResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token Google tidak valid',
                ], 401);
            }

            $googleData = $googleResponse->json();

            if (isset($googleData['exp']) && $googleData['exp'] < time()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token Google sudah expired, silakan login ulang',
                ], 401);
            }

            $googleId = $googleData['sub']    ?? null;
            $email    = $googleData['email']   ?? null;
            $name     = $googleData['name']    ?? ($googleData['given_name'] ?? 'User');
            $avatar   = $googleData['picture'] ?? null;

            if (!$googleId || !$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data dari Google tidak lengkap',
                ], 401);
            }

            $user  = $this->authService->findOrCreateFromGoogleData(
                $googleId, $email, $name, $avatar
            );
            $token = $this->authService->createToken(
                $user,
                $request->device_name ?? 'flutter_app'
            );

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data'    => [
                    'token' => $token,
                    'user'  => [
                        'id'         => $user->id,
                        'name'       => $user->name,
                        'email'      => $user->email,
                        'avatar'     => $user->avatar,
                        'is_premium' => $user->isPremium(),
                        'currency'   => $user->currency,
                        'locale'     => $user->locale,
                    ],
                ],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Autentikasi Google gagal',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 401);
        }
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'avatar'     => $user->avatar,
                'is_premium' => $user->isPremium(),
                'currency'   => $user->currency,
                'locale'     => $user->locale,
                'created_at' => $user->created_at,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $this->authService->revokeAllTokens($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logout dari semua perangkat berhasil',
        ]);
    }
}