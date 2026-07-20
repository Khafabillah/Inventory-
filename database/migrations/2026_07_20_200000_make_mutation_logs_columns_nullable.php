<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutation_logs', function (Blueprint $table) {
            // Memastikan semua kolom log yang opsional diizinkan bernilai NULL
            $table->unsignedBigInteger('asset_id')->nullable()->change();
            $table->unsignedBigInteger('old_room_id')->nullable()->change();
            $table->unsignedBigInteger('new_room_id')->nullable()->change();
            $table->string('action')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Tidak perlu dibalik karena ini sifatnya pengaman struktur
    }
};
