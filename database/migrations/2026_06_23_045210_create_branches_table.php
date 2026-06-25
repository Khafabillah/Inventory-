<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            // --- BAGIAN INI YANG DITAMBAHKAN ---
            $table->string('code', 10)->unique(); // Untuk kode seperti WML, WLD
            $table->string('name');              // Untuk nama cabang
            // -----------------------------------
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
