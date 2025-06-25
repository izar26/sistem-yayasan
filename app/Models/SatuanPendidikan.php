<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SatuanPendidikan extends Model
{
    use HasFactory;
    protected $table = 'satuan_pendidikans';
    protected $fillable = ['nama'];

    public function penugasans()
    {
        return $this->hasMany(Penugasan::class, 'id_satuan_pendidikan');
    }
}
