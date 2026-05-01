<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'judul_buku',
        'sub_judul',
        'isbn',
        'tahun_terbit',
        'deskripsi',
        'jumlah_halaman',
        'penerbit_id',
        'tempat_terbit',
        'edisi',
        'nomor_panggil',
        'stok'
    ];

    // RELASI KE PENERBIT
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }
}
