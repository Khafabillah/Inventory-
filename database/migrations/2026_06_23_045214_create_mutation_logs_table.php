<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutation_logs', function (Blueprint $table) {
            $table->id();

            // Relasi ke aset dan user yang memproses:
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Log lokasi asal dan tujuan:
            $table->unsignedBigInteger('old_room_id');
            $table->unsignedBigInteger('new_room_id');

            $table->text('description'); // Alasan mutasi
            $table->timestamp('mutation_date');
            $table->timestamps();

            // Definisi Foreign Key manual untuk ruangan:
            $table->foreign('old_room_id')->references('id')->on('rooms');
            $table->foreign('new_room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutation_logs');
    }
};
