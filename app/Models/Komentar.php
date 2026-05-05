<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar_buku';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'isi_komentar',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
