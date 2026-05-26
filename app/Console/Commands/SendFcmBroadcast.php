<?php

namespace App\Console\Commands;

use App\Services\FcmService;
use Illuminate\Console\Command;

class SendFcmBroadcast extends Command
{
    protected $signature = 'fcm:broadcast
                            {--title= : Judul notifikasi}
                            {--body=  : Isi notifikasi}
                            {--route= : Halaman tujuan saat notif di-tap (home/budget/premium/url:https://...)}
                            {--free-only : Hanya kirim ke user free (non-premium)}';

    protected $description = 'Kirim push notification FCM ke semua user atau hanya user free';

    public function handle(): int
    {
        $title = $this->option('title') ?? $this->ask('Judul notifikasi');
        $body  = $this->option('body')  ?? $this->ask('Isi notifikasi');

        if (empty($title) || empty($body)) {
            $this->error('Title dan body tidak boleh kosong.');
            return self::FAILURE;
        }

        $route    = $this->option('route') ?? 'home';
        $freeOnly = $this->option('free-only');
        $target   = $freeOnly ? 'user FREE' : 'semua user';
        $data     = ['route' => $route];

        $this->info("Mengirim notifikasi ke $target...");
        $this->line("  Judul : $title");
        $this->line("  Isi   : $body");
        $this->line("  Route : $route");

        if (! $this->confirm('Lanjutkan?', true)) {
            $this->warn('Dibatalkan.');
            return self::SUCCESS;
        }

        $result = $freeOnly
            ? FcmService::sendToFreeUsers($title, $body, $data)
            : FcmService::send($title, $body, null, $data);

        $this->info("Berhasil dikirim : {$result['sent']}");
        $this->warn("Gagal            : {$result['failed']}");

        return self::SUCCESS;
    }
}
