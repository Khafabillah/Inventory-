<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutation_logs', function (Blueprint $table) {
            // Membuat kolom asset_id boleh kosong (nullable) saat aset dihapus
            $table->unsignedBigInteger('asset_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('mutation_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('asset_id')->nullable(false)->change();
        });
    }
};
