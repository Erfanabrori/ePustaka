<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'buku_id'
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

    public static function existsForUserBook($userId, $bukuId)
    {
        return self::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->exists();
    }

    public static function findRaw($id)
    {
        return self::find($id);
    }
}
