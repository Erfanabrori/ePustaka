<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        $rows = DB::select('SELECT * FROM wishlists WHERE user_id = ? ORDER BY created_at DESC', [$userId]);
        $list = self::hydrate($rows);

        $bukuIds = $list->pluck('buku_id')->unique()->filter()->all();
        if (!empty($bukuIds)) {
            $placeholders = implode(',', array_fill(0, count($bukuIds), '?'));
            $pRows = DB::select("SELECT * FROM buku WHERE id IN ($placeholders)", $bukuIds);
            $bukus = Buku::hydrate($pRows)->keyBy('id');
            foreach ($list as $w) {
                $w->setRelation('buku', $bukus->get($w->buku_id) ?? null);
            }
        }

        return $list;
    }

    public static function existsForUserBook($userId, $bukuId)
    {
        $rows = DB::select('SELECT * FROM wishlists WHERE user_id = ? AND buku_id = ? LIMIT 1', [$userId, $bukuId]);
        return !empty($rows) ? self::hydrate($rows)->first() : null;
    }

    public static function findRaw($id)
    {
        $rows = DB::select('SELECT * FROM wishlists WHERE id = ? LIMIT 1', [$id]);
        return !empty($rows) ? self::hydrate($rows)->first() : null;
    }
}
