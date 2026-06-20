<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $rows = DB::select('SELECT * FROM peminjaman ORDER BY id ASC');
        $items = self::hydrate($rows);

        $bukuIds = $items->pluck('buku_id')->unique()->filter()->all();
        $userIds = $items->pluck('user_id')->unique()->filter()->all();

        if (!empty($bukuIds)) {
            $ids = implode(',', array_map('intval', $bukuIds));
            $pRows = DB::select("SELECT * FROM buku WHERE id IN ($ids)");
            $bukus = Buku::hydrate($pRows)->keyBy('id');
            foreach ($items as $it) {
                $it->setRelation('buku', $bukus->get($it->buku_id) ?? null);
            }
        }

        if (!empty($userIds)) {
            $ids = implode(',', array_map('intval', $userIds));
            $uRows = DB::select("SELECT * FROM users WHERE id IN ($ids)");
            $users = User::hydrate($uRows)->keyBy('id');
            foreach ($items as $it) {
                $it->setRelation('user', $users->get($it->user_id) ?? null);
            }
        }

        return $items;
    }

    public static function forUser($userId)
    {
        $rows = DB::select('SELECT * FROM peminjaman WHERE user_id = ? ORDER BY created_at DESC', [$userId]);
        $items = self::hydrate($rows);
        $bukuIds = $items->pluck('buku_id')->unique()->filter()->all();

        if (!empty($bukuIds)) {
            $ids = implode(',', array_map('intval', $bukuIds));
            $pRows = DB::select("SELECT * FROM buku WHERE id IN ($ids)");
            $bukus = Buku::hydrate($pRows)->keyBy('id');
            foreach ($items as $it) {
                $it->setRelation('buku', $bukus->get($it->buku_id) ?? null);
            }
        }

        return $items;
    }

    public static function countAll()
    {
        $rows = DB::select('SELECT COUNT(*) as cnt FROM peminjaman');
        return $rows[0]->cnt ?? 0;
    }

    public static function countByUser($userId)
    {
        $rows = DB::select('SELECT COUNT(*) as cnt FROM peminjaman WHERE user_id = ?', [$userId]);
        return $rows[0]->cnt ?? 0;
    }

    public static function report($bulan = null, $tahun = null)
    {
        $sql = 'SELECT * FROM peminjaman';
        $params = [];
        $conds = [];
        if ($bulan) {
            $conds[] = 'EXTRACT(MONTH FROM tanggal_pinjam) = ?';
            $params[] = $bulan;
        }
        if ($tahun) {
            $conds[] = 'EXTRACT(YEAR FROM tanggal_pinjam) = ?';
            $params[] = $tahun;
        }
        if ($conds) $sql .= ' WHERE ' . implode(' AND ', $conds);
        $sql .= ' ORDER BY tanggal_pinjam DESC';

        $rows = DB::select($sql, $params);
        $items = self::hydrate($rows);

        $bukuIds = $items->pluck('buku_id')->unique()->filter()->all();
        $userIds = $items->pluck('user_id')->unique()->filter()->all();

        if (!empty($bukuIds)) {
            $ids = implode(',', array_map('intval', $bukuIds));
            $pRows = DB::select("SELECT * FROM buku WHERE id IN ($ids)");
            $bukus = Buku::hydrate($pRows)->keyBy('id');
            foreach ($items as $it) {
                $it->setRelation('buku', $bukus->get($it->buku_id) ?? null);
            }
        }

        if (!empty($userIds)) {
            $ids = implode(',', array_map('intval', $userIds));
            $uRows = DB::select("SELECT * FROM users WHERE id IN ($ids)");
            $users = User::hydrate($uRows)->keyBy('id');
            foreach ($items as $it) {
                $it->setRelation('user', $users->get($it->user_id) ?? null);
            }
        }

        return $items;
    }

    public static function findRaw($id)
    {
        $rows = DB::select('SELECT * FROM peminjaman WHERE id = ? LIMIT 1', [$id]);
        return self::hydrate($rows)->first();
    }
}
