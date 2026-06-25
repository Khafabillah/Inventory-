<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel referensi:
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');

            // Detail aset:
            $table->string('asset_code')->unique(); // WLD-001
            $table->string('name');                 // AC Sharp
            $table->string('condition');            // Baik/Rusak

            // Path file (untuk foto dan QR):
            $table->string('image_path')->nullable();
            $table->string('qr_code_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
