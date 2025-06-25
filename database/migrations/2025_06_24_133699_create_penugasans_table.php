<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_penugasans_table.php
public function up(): void
{
    Schema::create('penugasans', function (Blueprint $table) {
        $table->id();
        // Ini adalah tabel relasi, kita definisikan semua foreign key
        $table->foreignId('id_tapel')->constrained('tapels')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('id_nomor_surat')->constrained('nomor_surats')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('id_pegawai')->constrained('pegawais')->onUpdate('cascade')->onDelete('cascade');
        $table->foreignId('id_satuan_pendidikan')->constrained('satuan_pendidikans')->onUpdate('cascade')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
