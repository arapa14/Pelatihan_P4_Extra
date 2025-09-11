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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            // simpan komponen agar audit tersedia
            $table->unsignedInteger('jumlah_gaji')->default(0);     // gaji pokok + tunjangan
            $table->unsignedInteger('jumlah_lembur')->default(0);   // total bayar lembur
            $table->unsignedInteger('potongan')->default(0);
            $table->unsignedInteger('gaji_diterima')->default(0);   // final
            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');
            // tanggal gaji tetap biarkan sebagai date, atau simpan bulan/tahun juga
            $table->date('tanggal_gaji');
            $table->timestamps();
            $table->unique(['pegawai_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
