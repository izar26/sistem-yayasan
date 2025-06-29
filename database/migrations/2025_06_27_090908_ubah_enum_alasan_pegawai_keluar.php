<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Rename nilai enum lama 'Mutase' jadi 'Mutasi'
        DB::statement("ALTER TABLE pegawai_keluar MODIFY alasan ENUM(
            'Mutasi', 'Dikeluarkan', 'Mengundurkan Diri', 'Wafat', 'Hilang', 'Alih Fungsi', 'Pensiun'
        )");

        // Update data lama kalau ada
        DB::table('pegawai_keluar')->where('alasan', 'Mutase')->update(['alasan' => 'Mutasi']);
    }

    public function down(): void
    {
        // Balik lagi ke enum lama (jaga-jaga rollback)
        DB::statement("ALTER TABLE pegawai_keluar MODIFY alasan ENUM(
            'Mutase', 'Dikeluarkan', 'Mengundurkan Diri', 'Wafat', 'Hilang', 'Alih Fungsi', 'Pensiun'
        )");

        DB::table('pegawai_keluar')->where('alasan', 'Mutasi')->update(['alasan' => 'Mutase']);
    }
};

