<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        if ($search) {
            $rows = DB::select('SELECT * FROM buku WHERE judul_buku LIKE ? ORDER BY id ASC', ['%'.$search.'%']);
        } else {
            $rows = DB::select('SELECT * FROM buku ORDER BY id ASC');
        }

        $books = self::hydrate($rows);

        $penerbitIds = $books->pluck('penerbit_id')->unique()->filter()->all();

        if (!empty($penerbitIds)) {
            $placeholders = implode(',', array_fill(0, count($penerbitIds), '?'));
            $pRows = DB::select("SELECT * FROM penerbit WHERE id IN ($placeholders)", $penerbitIds);
            $penerbits = Penerbit::hydrate($pRows)->keyBy('id');

            foreach ($books as $b) {
                $p = $penerbits->get($b->penerbit_id) ?? null;
                if ($p) $b->setRelation('penerbit', $p);
            }
        }

        return $books;
    }

    public static function findRaw($id)
    {
        $rows = DB::select('SELECT * FROM buku WHERE id = ? LIMIT 1', [$id]);
        $model = self::hydrate($rows)->first();
        if ($model) {
            $p = DB::select('SELECT * FROM penerbit WHERE id = ? LIMIT 1', [$model->penerbit_id]);
            if ($p) $model->setRelation('penerbit', Penerbit::hydrate($p)->first());
        }
        return $model;
    }

    public static function allRaw()
    {
        $rows = DB::select('SELECT * FROM buku ORDER BY id ASC');
        return self::hydrate($rows);
    }
}
