<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat satu admin default jika belum ada
        Admin::updateOrCreate(
            ['email' => 'admin@yayasan.com'], // Kunci untuk mencari
            [
                'username' => 'admin',
                'password' => Hash::make('password'), // Selalu hash password
            ]
        );
    }
}
