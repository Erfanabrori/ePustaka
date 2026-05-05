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

    // RELASI KE BUKU (WAJIB HURUF KECIL)
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
