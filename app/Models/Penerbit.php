<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penerbit extends Model
{
    protected $table = 'penerbit';

    protected $fillable = [
        'nama_penerbit'
    ];

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA DATA PENERBIT
    |--------------------------------------------------------------------------
    */
    public static function allRaw()
    {
        return DB::select("
            SELECT *
            FROM penerbit
            ORDER BY id ASC
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | CARI PENERBIT BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public static function findRaw($id)
    {
        $data = DB::select("
            SELECT *
            FROM penerbit
            WHERE id = ?
            LIMIT 1
        ", [$id]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH DATA PENERBIT
    |--------------------------------------------------------------------------
    */
    public static function insertRaw($data)
    {
        return DB::insert("
            INSERT INTO penerbit (
                nama_penerbit,
                created_at,
                updated_at
            ) VALUES (?, NOW(), NOW())
        ", [
            $data['nama_penerbit']
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA PENERBIT
    |--------------------------------------------------------------------------
    */
    public static function updateRaw($id, $data)
    {
        return DB::update("
            UPDATE penerbit SET
                nama_penerbit = ?,
                updated_at = NOW()
            WHERE id = ?
        ", [
            $data['nama_penerbit'],
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA PENERBIT
    |--------------------------------------------------------------------------
    */
    public static function deleteRaw($id)
    {
        return DB::delete("
            DELETE FROM penerbit
            WHERE id = ?
        ", [$id]);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL BUKU BERDASARKAN PENERBIT
    |--------------------------------------------------------------------------
    */
    public static function bukuByPenerbit($penerbitId)
    {
        return DB::select("
            SELECT *
            FROM buku
            WHERE penerbit_id = ?
            ORDER BY id ASC
        ", [$penerbitId]);
    }
}
