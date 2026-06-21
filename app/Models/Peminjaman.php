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

    public static function allWithRelations()
    {
        return self::with(['buku', 'user'])
            ->orderBy('id', 'asc')
            ->get();
    }

    public static function forUser($userId)
    {
        return self::with('buku')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function countAll()
    {
        return self::count();
    }

    public static function countByUser($userId)
    {
        return self::where('user_id', $userId)->count();
    }

    public static function report($bulan = null, $tahun = null)
    {
        $query = self::with(['buku', 'user']);

        if ($bulan) {
            $query->whereMonth('tanggal_pinjam', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal_pinjam', $tahun);
        }

        return $query->orderBy('tanggal_pinjam', 'desc')->get();
    }

    public static function findRaw($id)
    {
        return self::find($id);
    }
}
