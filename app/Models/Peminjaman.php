<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemBuku;
use App\Models\User;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'item_buku_id',
        'tanggal_pinjam',
        'tanggal_kembali'
    ];

    // RELASI ITEM BUKU (INI WAJIB SAMA DENGAN WITH DI CONTROLLER)
    public function itemBuku()
    {
        return $this->belongsTo(ItemBuku::class, 'item_buku_id');
    }

    // RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}