<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus atau beri komentar pada seeder User bawaan
        // \App\Models\User::factory(10)->create();

        // Panggil seeder admin di sini
        $this->call([
            AdminSeeder::class,
            // Anda bisa menambahkan seeder lain di sini nanti,
            // misalnya SatuanPendidikanSeeder, dll.
        ]);
    }
}
