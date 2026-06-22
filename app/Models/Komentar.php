<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'user_id',
        'buku_id',
        'isi_komentar',
        'rating',
    ];

    /*
    |--------------------------------------------------------------------------
    | AMBIL KOMENTAR MILIK USER TERTENTU + DATA BUKU
    |--------------------------------------------------------------------------
    */
    public static function forUser($userId)
    {
        return DB::select("
            SELECT
                komentar.*,
                buku.judul_buku
            FROM komentar
            LEFT JOIN buku
                ON komentar.buku_id = buku.id
            WHERE komentar.user_id = ?
            ORDER BY komentar.created_at DESC
        ", [$userId]);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA KOMENTAR UNTUK ADMIN + DATA BUKU DAN USER
    |--------------------------------------------------------------------------
    */
    public static function adminAll()
    {
        return DB::select("
            SELECT
                komentar.*,
                buku.judul_buku,
                users.name AS nama_user,
                users.email AS email_user
            FROM komentar
            LEFT JOIN buku
                ON komentar.buku_id = buku.id
            LEFT JOIN users
                ON komentar.user_id = users.id
            ORDER BY komentar.created_at DESC
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | CARI KOMENTAR BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public static function findRaw($id)
    {
        $data = DB::select("
            SELECT *
            FROM komentar
            WHERE id = ?
            LIMIT 1
        ", [$id]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | CARI KOMENTAR BERDASARKAN ID + DATA BUKU DAN USER
    |--------------------------------------------------------------------------
    */
    public static function findWithRelations($id)
    {
        $data = DB::select("
            SELECT
                komentar.*,
                buku.judul_buku,
                users.name AS nama_user,
                users.email AS email_user
            FROM komentar
            LEFT JOIN buku
                ON komentar.buku_id = buku.id
            LEFT JOIN users
                ON komentar.user_id = users.id
            WHERE komentar.id = ?
            LIMIT 1
        ", [$id]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH KOMENTAR BARU
    |--------------------------------------------------------------------------
    */
    public static function insertRaw($data)
    {
        return DB::insert("
            INSERT INTO komentar (
                user_id,
                buku_id,
                isi_komentar,
                rating,
                created_at,
                updated_at
            ) VALUES (?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['user_id'],
            $data['buku_id'],
            $data['isi_komentar'],
            $data['rating'] ?? null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE KOMENTAR
    |--------------------------------------------------------------------------
    */
    public static function updateRaw($id, $data)
    {
        return DB::update("
            UPDATE komentar SET
                buku_id = ?,
                isi_komentar = ?,
                rating = ?,
                updated_at = NOW()
            WHERE id = ?
        ", [
            $data['buku_id'],
            $data['isi_komentar'],
            $data['rating'] ?? null,
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS KOMENTAR
    |--------------------------------------------------------------------------
    */
    public static function deleteRaw($id)
    {
        return DB::delete("
            DELETE FROM komentar
            WHERE id = ?
        ", [$id]);
    }
}
