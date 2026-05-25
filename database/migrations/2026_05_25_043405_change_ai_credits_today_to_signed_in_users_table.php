<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('ai_credits_today')->default(0)->change();
        });
    }

    public function down(): void
    {
        DB::statement('UPDATE users SET ai_credits_today = 0 WHERE ai_credits_today < 0');

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('ai_credits_today')->default(0)->change();
        });
    }
};
