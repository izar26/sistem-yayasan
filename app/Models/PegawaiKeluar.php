<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PegawaiKeluar extends Model
{
    use HasFactory;
    protected $table = 'pegawai_keluar';
    protected $fillable = ['alasan', 'pegawai_id'];


    public function pegawai()
{
    return $this->belongsTo(\App\Models\Pegawai::class);
}

}

