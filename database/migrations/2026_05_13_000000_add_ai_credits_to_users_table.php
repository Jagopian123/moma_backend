<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('ai_credits_today')->default(0)->after('premium_expires_at');
            $table->date('ai_credits_date')->nullable()->after('ai_credits_today');
            $table->string('last_purchase_token')->nullable()->after('ai_credits_date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ai_credits_today', 'ai_credits_date', 'last_purchase_token']);
        });
    }
};
