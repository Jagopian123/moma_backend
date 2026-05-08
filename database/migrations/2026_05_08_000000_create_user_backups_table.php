<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_backups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText('data');         // JSON string semua data Hive
            $table->timestamp('backed_up_at');
            $table->timestamps();

            $table->unique('user_id'); // satu backup per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_backups');
    }
};
