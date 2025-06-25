<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// TAMBAHKAN USE STATEMENT INI
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// UBAH 'extends Model' MENJADI 'extends Authenticatable'
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token', // Tambahkan ini juga
    ];
}