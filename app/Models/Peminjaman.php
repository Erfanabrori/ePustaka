<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali'
    ];

    // RELASI ITEM BUKU (INI WAJIB SAMA DENGAN WITH DI CONTROLLER)
    public function Buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
