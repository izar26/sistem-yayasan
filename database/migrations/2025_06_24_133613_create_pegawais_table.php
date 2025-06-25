<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_pegawais_table.php
public function up(): void
{
    Schema::create('pegawais', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 50);
        $table->string('jenjang_pendidikan', 50);
        $table->string('jabatan', 50);
        $table->enum('kewarganegaraan', ['WNI', 'WNA'])->nullable();
        $table->string('nik', 16)->unique(); // NIK harus unik
        $table->string('nuptk', 16)->nullable();
        $table->string('nip', 18)->nullable(); // NIP biasanya 18 digit
        $table->string('nipy', 16)->nullable();
        $table->string('npwp', 16)->nullable();
        $table->string('tmp_lahir', 50); // varchar(15) mungkin kurang
        $table->date('tgl_lahir')->nullable();
        $table->enum('jk', ['L', 'P'])->nullable();
        $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Buddha', 'Hindu'])->nullable();
        $table->string('nama_ibu', 50);
        $table->enum('status_pernikahan', ['Menikah', 'Lajang', 'Duda', 'Janda'])->nullable();
        $table->string('nama_suami_istri', 50)->nullable();
        $table->string('jml_anak', 5)->nullable();
        $table->text('alamat')->nullable();
        $table->string('kecamatan', 25);
        $table->string('desa', 25);
        $table->string('kabupaten', 25);
        $table->string('provinsi', 25);
        $table->string('kode_pos', 15);
        $table->string('kontak')->nullable();
        $table->string('photo', 100)->nullable();
        $table->boolean('status')->default(true); // Status aktif/pensiun/dll
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
