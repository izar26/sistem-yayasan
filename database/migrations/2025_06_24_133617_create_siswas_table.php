<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_siswas_table.php
public function up(): void
{
    Schema::create('siswas', function (Blueprint $table) {
        // Primary key bukan id, tapi NIK
        $table->string('nik', 16)->primary(); // Ganti char(7) ke string(16) untuk NIK standar
        $table->string('nama'); // text tidak diperlukan untuk nama
        $table->enum('jk', ['L', 'P'])->nullable();
        $table->text('alamat')->nullable();
        $table->string('kelas')->nullable(); // text tidak diperlukan
        $table->integer('nilai')->nullable();
        $table->integer('absen')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
