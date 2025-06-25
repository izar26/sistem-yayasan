<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tapel extends Model
{
    use HasFactory;
    protected $fillable = ['tapel', 'ket', 'status'];

    public function penugasans()
    {
        return $this->hasMany(Penugasan::class, 'id_tapel');
    }

    public function nomorSurats()
    {
        return $this->hasMany(NomorSurat::class, 'id_tapel');
    }
}
