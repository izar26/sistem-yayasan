<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * Karena kolomnya sangat banyak, cara aman adalah menggunakan $guarded
     * untuk mengizinkan semua field diisi kecuali 'id'.
     */
    protected $guarded = ['id'];

    /**
     * === PERBAIKAN UTAMA ADA DI SINI ===
     * Memberitahu Laravel untuk secara otomatis mengubah kolom ini 
     * menjadi objek Tanggal (Carbon) setiap kali data diambil.
     */
    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    /**
     * Mendefinisikan relasi ke model Penugasan.
     */
    public function penugasans()
    {
        return $this->hasMany(Penugasan::class, 'id_pegawai');
    }
}
