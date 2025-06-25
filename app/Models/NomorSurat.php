<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorSurat extends Model
{
    use HasFactory;
    
    protected $table = 'nomor_surats';
    protected $guarded = ['id'];

    /**
     * === PERBAIKAN UTAMA ADA DI SINI ===
     * Memberitahu Laravel untuk secara otomatis mengubah kolom ini menjadi objek Tanggal (Carbon).
     */
    protected $casts = [
        'tgl_sp' => 'date',
        'tmt' => 'date',
    ];

    /**
     * Mendefinisikan relasi ke model Tapel.
     */
    public function tapel()
    {
        return $this->belongsTo(Tapel::class, 'id_tapel');
    }
}
