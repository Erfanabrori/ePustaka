<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA DATA BUKU + PENERBIT (QUERY MANUAL)
    |--------------------------------------------------------------------------
    */
    public static function fetchForIndex($search = null)
    {
        $sql = "
            SELECT
                buku.*,
                penerbit.nama_penerbit
            FROM buku
            LEFT JOIN penerbit
                ON buku.penerbit_id = penerbit.id
        ";

        $params = [];

        if ($search) {
            $sql .= " WHERE buku.judul_buku LIKE ? ";
            $params[] = "%{$search}%";
        }

        $sql .= " ORDER BY buku.id ASC ";

        return DB::select($sql, $params);
    }

    /*
    |--------------------------------------------------------------------------
    | CARI 1 BUKU BERDASARKAN ID + DATA PENERBIT
    |--------------------------------------------------------------------------
    */
    public static function findRaw($id)
    {
        $data = DB::select("
            SELECT
                buku.*,
                penerbit.nama_penerbit
            FROM buku
            LEFT JOIN penerbit
                ON buku.penerbit_id = penerbit.id
            WHERE buku.id = ?
            LIMIT 1
        ", [$id]);

        return $data[0] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA DATA BUKU SAJA
    |--------------------------------------------------------------------------
    */
    public static function allRaw()
    {
        return DB::select("
            SELECT *
            FROM buku
            ORDER BY id ASC
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH DATA BUKU (INSERT MANUAL)
    |--------------------------------------------------------------------------
    */
    public static function insertRaw($data)
    {
        return DB::insert("
            INSERT INTO buku (
                judul_buku,
                sub_judul,
                isbn,
                tahun_terbit,
                deskripsi,
                jumlah_halaman,
                penerbit_id,
                tempat_terbit,
                edisi,
                nomor_panggil,
                stok,
                created_at,
                updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['judul_buku'],
            $data['sub_judul'] ?? null,
            $data['isbn'] ?? null,
            $data['tahun_terbit'] ?? null,
            $data['deskripsi'] ?? null,
            $data['jumlah_halaman'] ?? null,
            $data['penerbit_id'] ?? null,
            $data['tempat_terbit'] ?? null,
            $data['edisi'] ?? null,
            $data['nomor_panggil'] ?? null,
            $data['stok'] ?? 0
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA BUKU (UPDATE MANUAL)
    |--------------------------------------------------------------------------
    */
    public static function updateRaw($id, $data)
    {
        return DB::update("
            UPDATE buku SET
                judul_buku = ?,
                sub_judul = ?,
                isbn = ?,
                tahun_terbit = ?,
                deskripsi = ?,
                jumlah_halaman = ?,
                penerbit_id = ?,
                tempat_terbit = ?,
                edisi = ?,
                nomor_panggil = ?,
                stok = ?,
                updated_at = NOW()
            WHERE id = ?
        ", [
            $data['judul_buku'],
            $data['sub_judul'] ?? null,
            $data['isbn'] ?? null,
            $data['tahun_terbit'] ?? null,
            $data['deskripsi'] ?? null,
            $data['jumlah_halaman'] ?? null,
            $data['penerbit_id'] ?? null,
            $data['tempat_terbit'] ?? null,
            $data['edisi'] ?? null,
            $data['nomor_panggil'] ?? null,
            $data['stok'] ?? 0,
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA BUKU (DELETE MANUAL)
    |--------------------------------------------------------------------------
    */
    public static function deleteRaw($id)
    {
        return DB::delete("
            DELETE FROM buku
            WHERE id = ?
        ", [$id]);
    }
}
