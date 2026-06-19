<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        $rows = DB::select('SELECT * FROM komentar WHERE user_id = ? ORDER BY created_at DESC', [$userId]);
        $comments = self::hydrate($rows);

        $bukuIds = $comments->pluck('buku_id')->unique()->filter()->all();
        if (!empty($bukuIds)) {
            $placeholders = implode(',', array_fill(0, count($bukuIds), '?'));
            $pRows = DB::select("SELECT * FROM buku WHERE id IN ($placeholders)", $bukuIds);
            $bukus = Buku::hydrate($pRows)->keyBy('id');
            foreach ($comments as $c) {
                $c->setRelation('buku', $bukus->get($c->buku_id) ?? null);
            }
        }

        return $comments;
    }

    public static function adminAll()
    {
        $rows = DB::select('SELECT * FROM komentar ORDER BY created_at DESC');
        $comments = self::hydrate($rows);

        $bukuIds = $comments->pluck('buku_id')->unique()->filter()->all();
        $userIds = $comments->pluck('user_id')->unique()->filter()->all();

        if (!empty($bukuIds)) {
            $placeholders = implode(',', array_fill(0, count($bukuIds), '?'));
            $pRows = DB::select("SELECT * FROM buku WHERE id IN ($placeholders)", $bukuIds);
            $bukus = Buku::hydrate($pRows)->keyBy('id');
            foreach ($comments as $c) {
                $c->setRelation('buku', $bukus->get($c->buku_id) ?? null);
            }
        }

        if (!empty($userIds)) {
            $placeholders = implode(',', array_fill(0, count($userIds), '?'));
            $uRows = DB::select("SELECT * FROM users WHERE id IN ($placeholders)", $userIds);
            $users = User::hydrate($uRows)->keyBy('id');
            foreach ($comments as $c) {
                $c->setRelation('user', $users->get($c->user_id) ?? null);
            }
        }

        return $comments;
    }

    public static function findRaw($id)
    {
        $rows = DB::select('SELECT * FROM komentar WHERE id = ? LIMIT 1', [$id]);
        return self::hydrate($rows)->first();
    }

    public static function findWithRelations($id)
    {
        $item = self::findRaw($id);
        if (!$item) return null;

        $b = DB::select('SELECT * FROM buku WHERE id = ? LIMIT 1', [$item->buku_id]);
        if ($b) $item->setRelation('buku', Buku::hydrate($b)->first());

        $u = DB::select('SELECT * FROM users WHERE id = ? LIMIT 1', [$item->user_id]);
        if ($u) $item->setRelation('user', User::hydrate($u)->first());

        return $item;
    }
}
