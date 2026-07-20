<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutation_logs', function (Blueprint $table) {
            // Menambahkan kolom action yang kurang
            if (!Schema::hasColumn('mutation_logs', 'action')) {
                $table->string('action')->nullable();
            }

            // Membuat old_room_id boleh kosong (nullable) untuk log tambah aset
            $table->unsignedBigInteger('old_room_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('mutation_logs', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }
};
