<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_nomor_surats_table.php
public function up(): void
{
    Schema::create('nomor_surats', function (Blueprint $table) {
        $table->id();
        // Foreign key ke tabel tapels
        $table->foreignId('id_tapel')->constrained('tapels')->onUpdate('cascade')->onDelete('cascade');
        $table->string('no_surat', 100);
        $table->string('nama_pimpinan', 25);
        $table->date('tgl_sp')->nullable();
        $table->date('tmt')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_surats');
    }
};
