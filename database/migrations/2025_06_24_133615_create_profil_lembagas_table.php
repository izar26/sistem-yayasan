<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_profil_lembagas_table.php
public function up(): void
{
    // Tabel ini biasanya hanya berisi 1 baris data.
    Schema::create('profil_lembagas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('npyn', 16);
        $table->date('thn_berdiri')->nullable();
        $table->string('luas', 15);
        $table->text('moto')->nullable();
        $table->string('logo', 100)->nullable();
        $table->text('alamat')->nullable();
        $table->string('desa', 50); // varchar(15) mungkin kurang
        $table->string('kecamatan', 50);
        $table->string('kabupaten', 50);
        $table->string('provinsi', 50);
        $table->string('kode_pos', 10);
        $table->string('telepon', 20);
        $table->string('fax', 20);
        $table->string('email', 50);
        $table->string('situs_web')->nullable();
        $table->string('facebook')->nullable();
        $table->string('youtube')->nullable();
        $table->string('tiktok')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_lembagas');
    }
};
