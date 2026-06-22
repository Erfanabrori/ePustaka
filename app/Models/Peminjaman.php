<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA PEMINJAMAN + BUKU + USER
    |--------------------------------------------------------------------------
    */
    public static function allWithRelations()
    {
        return DB::select("
            SELECT
                peminjaman.*,
                buku.judul_buku,
                users.name AS nama_user,
                users.email AS email_user
            FROM peminjaman
            LEFT JOIN buku
                ON peminjaman.buku_id = buku.id
            LEFT JOIN users
                ON peminjaman.user_id = users.id
            ORDER BY peminjaman.id ASC
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL PEMINJAMAN BERDASARKAN USER + DATA BUKU
    |--------------------------------------------------------------------------
    */
    public static function forUser($userId)
    {
        return DB::select("
            SELECT
                peminjaman.*,
                buku.judul_buku
            FROM peminjaman
            LEFT JOIN buku
                ON peminjaman.buku_id = buku.id
            WHERE peminjaman.user_id = ?
            ORDER BY peminjaman.created_at DESC
        ", [$userId]);
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG SELURUH DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public static function countAll()
    {
        $data = DB::select("
            SELECT COUNT(*) AS total
            FROM peminjaman
        ");

        return $data[0]->total ?? 0;
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG PEMINJAMAN BERDASARKAN USER
    |--------------------------------------------------------------------------
    */
    public static function countByUser($userId)
    {
        $data = DB::select("
            SELECT COUNT(*) AS total
            FROM peminjaman
            WHERE user_id = ?
        ", [$userId]);

        return $data[0]->total ?? 0;
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN PEMINJAMAN BERDASARKAN BULAN DAN TAHUN
    |--------------------------------------------------------------------------
    */
    public static function report($bulan = null, $tahun = null)
    {
        $sql = "
        SELECT
            peminjaman.*,
            buku.judul_buku,
            users.name AS nama_user,
            users.email AS email_user
        FROM peminjaman
        LEFT JOIN buku ON peminjaman.buku_id = buku.id
        LEFT JOIN users ON peminjaman.user_id = users.id
        WHERE 1 = 1
    ";

        $params = [];

        if ($bulan) {
            $sql .= " AND EXTRACT(MONTH FROM peminjaman.tanggal_pinjam) = ? ";
            $params[] = $bulan;
        }

        if ($tahun) {
            $sql .= " AND EXTRACT(YEAR FROM peminjaman.tanggal_pinjam) = ? ";
            $params[] = $tahun;
        }

        $sql .= " ORDER BY peminjaman.tanggal_pinjam DESC ";

        return DB::select($sql, $params);
    }

    /*
    |--------------------------------------------------------------------------
    | CARI PEMINJAMAN BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public static function findRaw($id)
    {
        $data = DB::select("
            SELECT *
            FROM peminjaman
            WHERE id = ?
            LIMIT 1
        ", [$id]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public static function insertRaw($data)
    {
        return DB::insert("
            INSERT INTO peminjaman (
                user_id,
                buku_id,
                tanggal_pinjam,
                tanggal_kembali,
                created_at,
                updated_at
            ) VALUES (?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['user_id'],
            $data['buku_id'],
            $data['tanggal_pinjam'],
            $data['tanggal_kembali'] ?? null
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public static function updateRaw($id, $data)
    {
        return DB::update("
            UPDATE peminjaman SET
                user_id = ?,
                buku_id = ?,
                tanggal_pinjam = ?,
                tanggal_kembali = ?,
                updated_at = NOW()
            WHERE id = ?
        ", [
            $data['user_id'],
            $data['buku_id'],
            $data['tanggal_pinjam'],
            $data['tanggal_kembali'] ?? null,
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public static function deleteRaw($id)
    {
        return DB::delete("
            DELETE FROM peminjaman
            WHERE id = ?
        ", [$id]);
    }
}
