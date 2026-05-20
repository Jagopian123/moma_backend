<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_backups', function (Blueprint $table) {
            // Flag apakah kolom data menyimpan gzip+base64 atau JSON mentah
            $table->boolean('is_compressed')->default(false)->after('data');
        });
    }

    public function down(): void
    {
        Schema::table('user_backups', function (Blueprint $table) {
            $table->dropColumn('is_compressed');
        });
    }
};
