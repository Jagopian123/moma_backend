<?php

namespace App\Services;

use App\Models\DeviceToken;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FcmService
{
    public static function send(string $title, string $body, ?int $userId = null, array $data = []): array
    {
        $query = DeviceToken::query();

        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        $tokens = $query->pluck('token')->toArray();

        if (empty($tokens)) {
            return ['sent' => 0, 'failed' => 0];
        }

        $messaging = Firebase::messaging();
        $notification = Notification::create($title, $body);

        $sent = 0;
        $failed = 0;

        // FCM mendukung max 500 token per request
        foreach (array_chunk($tokens, 500) as $chunk) {
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            try {
                $report = $messaging->sendMulticast($message, $chunk);
                $sent += $report->successes()->count();
                $failed += $report->failures()->count();

                // Hapus token yang sudah tidak valid
                foreach ($report->failures()->getItems() as $failure) {
                    $invalidToken = $failure->target()->value();
                    DeviceToken::where('token', $invalidToken)->delete();
                }
            } catch (\Throwable) {
                $failed += count($chunk);
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    public static function sendToFreeUsers(string $title, string $body, array $data = []): array
    {
        $tokens = DeviceToken::whereHas('user', fn ($q) => $q->where('is_premium', false))
            ->pluck('token')
            ->toArray();

        if (empty($tokens)) {
            return ['sent' => 0, 'failed' => 0];
        }

        $messaging = Firebase::messaging();
        $notification = Notification::create($title, $body);
        $sent = 0;
        $failed = 0;

        foreach (array_chunk($tokens, 500) as $chunk) {
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            try {
                $report = $messaging->sendMulticast($message, $chunk);
                $sent += $report->successes()->count();
                $failed += $report->failures()->count();

                foreach ($report->failures()->getItems() as $failure) {
                    DeviceToken::where('token', $failure->target()->value())->delete();
                }
            } catch (\Throwable) {
                $failed += count($chunk);
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }
}
