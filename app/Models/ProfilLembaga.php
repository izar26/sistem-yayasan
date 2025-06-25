<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilLembaga extends Model
{
    use HasFactory;
    protected $table = 'profil_lembagas';
    protected $guarded = ['id']; // Karena kolomnya banyak
}
