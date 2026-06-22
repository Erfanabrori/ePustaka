<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'buku_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | AMBIL WISHLIST BERDASARKAN USER + DATA BUKU
    |--------------------------------------------------------------------------
    */
    public static function forUser($userId)
    {
        return DB::select("
            SELECT
                wishlists.*,
                buku.judul_buku,
                buku.sub_judul,
                buku.isbn,
                buku.tahun_terbit,
                buku.stok
            FROM wishlists
            LEFT JOIN buku
                ON wishlists.buku_id = buku.id
            WHERE wishlists.user_id = ?
            ORDER BY wishlists.created_at DESC
        ", [$userId]);
    }

    /*
    |--------------------------------------------------------------------------
    | CEK APAKAH BUKU SUDAH ADA DI WISHLIST USER
    |--------------------------------------------------------------------------
    */
    public static function existsForUserBook($userId, $bukuId)
    {
        $data = DB::select("
            SELECT id
            FROM wishlists
            WHERE user_id = ?
            AND buku_id = ?
            LIMIT 1
        ", [$userId, $bukuId]);

        return !empty($data);
    }

    /*
    |--------------------------------------------------------------------------
    | CARI WISHLIST BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public static function findRaw($id)
    {
        $data = DB::select("
            SELECT *
            FROM wishlists
            WHERE id = ?
            LIMIT 1
        ", [$id]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | CARI WISHLIST BERDASARKAN USER DAN BUKU
    |--------------------------------------------------------------------------
    */
    public static function findByUserBookRaw($userId, $bukuId)
    {
        $data = DB::select("
            SELECT *
            FROM wishlists
            WHERE user_id = ?
            AND buku_id = ?
            LIMIT 1
        ", [$userId, $bukuId]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH WISHLIST
    |--------------------------------------------------------------------------
    */
    public static function insertRaw($data)
    {
        return DB::insert("
            INSERT INTO wishlists (
                user_id,
                buku_id,
                created_at,
                updated_at
            ) VALUES (?, ?, NOW(), NOW())
        ", [
            $data['user_id'],
            $data['buku_id']
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS WISHLIST BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public static function deleteRaw($id)
    {
        return DB::delete("
            DELETE FROM wishlists
            WHERE id = ?
        ", [$id]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS WISHLIST BERDASARKAN USER DAN BUKU
    |--------------------------------------------------------------------------
    */
    public static function deleteByUserBookRaw($userId, $bukuId)
    {
        return DB::delete("
            DELETE FROM wishlists
            WHERE user_id = ?
            AND buku_id = ?
        ", [$userId, $bukuId]);
    }
}
