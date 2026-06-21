<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penerbit;

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

    public static function fetchForIndex($search = null)
    {
        $query = self::with('penerbit')->orderBy('id', 'asc');

        if ($search) {
            $query->where('judul_buku', 'like', "%{$search}%");
        }

        return $query->get();
    }

    public static function findRaw($id)
    {
        return self::with('penerbit')->find($id);
    }

    public static function allRaw()
    {
        return self::orderBy('id', 'asc')->get();
    }
}
