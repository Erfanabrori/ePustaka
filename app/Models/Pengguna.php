<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'nama', 'email', 'password'
    ];

}
