<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBuku extends Model
{
    protected $table = 'item_buku';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun'
    ];
}
