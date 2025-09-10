<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('golongans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedInteger('gaji_pokok')->default(0);
            $table->unsignedInteger('tunjangan_keluarga')->default(0);
            $table->unsignedInteger('tunjangan_transport')->default(0);
            $table->unsignedInteger('tunjangan_makan')->default(0);
            // opsional: tarif lembur per jam untuk golongan ini
            $table->unsignedInteger('tarif_lembur_per_jam')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('golongans');
    }
};
