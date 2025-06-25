<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tapel()
    {
        return $this->belongsTo(Tapel::class, 'id_tapel');
    }

    public function nomorSurat()
    {
        return $this->belongsTo(NomorSurat::class, 'id_nomor_surat');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function satuanPendidikan()
    {
        return $this->belongsTo(SatuanPendidikan::class, 'id_satuan_pendidikan');
    }
}
