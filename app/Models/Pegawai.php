<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];
    protected $table = 'pegawais';

    public function penugasans()
    {
        return $this->hasMany(Penugasan::class, 'id_pegawai');
    }

    public function satuanPendidikan()
    {
        return $this->belongsTo(SatuanPendidikan::class, 'id_satuan_pendidikan');
    }
   public function keluar()
{
    return $this->hasOne(\App\Models\PegawaiKeluar::class, 'pegawai_id');
}



}
