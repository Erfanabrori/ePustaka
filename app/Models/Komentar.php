<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'user_id',
        'buku_id',
        'isi_komentar',
        'rating',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function forUser($userId)
    {
        return self::with('buku')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function adminAll()
    {
        return self::with(['buku', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function findRaw($id)
    {
        return self::find($id);
    }

    public static function findWithRelations($id)
    {
        return self::with(['buku', 'user'])->find($id);
    }
}
