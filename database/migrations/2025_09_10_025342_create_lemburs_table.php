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
        Schema::create('lemburs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            // Simpan bulan dan tahun agar mudah query per bulan
            $table->unsignedTinyInteger('bulan'); // 1..12
            $table->unsignedSmallInteger('tahun'); // 2025, dsb
            $table->unsignedInteger('jumlah_jam')->default(0); // jumlah jam lembur
            // opsional: simpan rate saat pencatatan sehingga riwayat tidak berubah bila tarif berubah
            $table->unsignedInteger('rate_per_jam')->nullable();
            $table->timestamps();
            $table->index(['pegawai_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemburs');
    }
};
