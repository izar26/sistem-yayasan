<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Tambahkan kolom foreign key jika belum ada
            if (!Schema::hasColumn('pegawais', 'id_satuan_pendidikan')) {
                $table->foreignId('id_satuan_pendidikan')->after('id')->nullable()->constrained('satuan_pendidikans')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Cek dulu sebelum menghapus untuk menghindari error
            if (Schema::hasColumn('pegawais', 'id_satuan_pendidikan')) {
                $table->dropForeign(['id_satuan_pendidikan']);
                $table->dropColumn('id_satuan_pendidikan');
            }
        });
    }
};
