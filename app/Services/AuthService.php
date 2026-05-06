<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function findOrCreateFromGoogleData(
        string  $googleId,
        string  $email,
        string  $name,
        ?string $avatar
    ): User {
        $user = User::where('google_id', $googleId)->first();

        if ($user) {
            $user->update([
                'avatar' => $avatar,
                'name'   => $name,
            ]);
            return $user;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'google_id'         => $googleId,
                'avatar'            => $avatar,
                'email_verified_at' => now(),
            ]);
            return $user;
        }

        return User::create([
            'name'              => $name,
            'email'             => $email,
            'avatar'            => $avatar,
            'google_id'         => $googleId,
            'email_verified_at' => now(),
            'currency'          => 'IDR',
            'locale'            => 'id',
        ]);
    }

    public function createToken(User $user, string $deviceName = 'flutter_app'): string
    {
        $user->tokens()->where('name', $deviceName)->delete();
        return $user->createToken($deviceName)->plainTextToken;
    }

    public function revokeAllTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}