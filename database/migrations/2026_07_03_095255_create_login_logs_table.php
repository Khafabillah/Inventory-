<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('login_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id');
        $table->string('ip_address');
        $table->string('user_agent');
        $table->timestamps(); // Ini otomatis buat created_at & updated_at
    });
}
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
