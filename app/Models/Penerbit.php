<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penerbit extends Model
{
    protected $table = 'penerbit';

    protected $fillable = ['nama_penerbit'];

    // relasi ke buku (optional tapi bagus)
    public function buku()
    {
        return $this->hasMany(Buku::class, 'penerbit_id');
    }

    public static function allRaw()
    {
        $rows = DB::select('SELECT * FROM penerbit ORDER BY id ASC');
        return self::hydrate($rows);
    }
}
