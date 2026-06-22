<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CARI USER BERDASARKAN EMAIL
    |--------------------------------------------------------------------------
    | Dibuat sebagai object User agar Hash::check() dan session login tetap aman.
    */
    public static function findByEmailRaw($email)
    {
        $data = DB::select("
            SELECT *
            FROM users
            WHERE email = ?
            LIMIT 1
        ", [$email]);

        if (empty($data)) {
            return null;
        }

        return self::hydrate([
            (array) $data[0]
        ])->first();
    }

    /*
    |--------------------------------------------------------------------------
    | CARI USER BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public static function findRaw($id)
    {
        $data = DB::select("
            SELECT *
            FROM users
            WHERE id = ?
            LIMIT 1
        ", [$id]);

        if (empty($data)) {
            return null;
        }

        return self::hydrate([
            (array) $data[0]
        ])->first();
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG TOTAL USER
    |--------------------------------------------------------------------------
    */
    public static function countRaw()
    {
        $data = DB::select("
            SELECT COUNT(*) AS total
            FROM users
        ");

        return $data[0]->total ?? 0;
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL USER BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */
    public static function allByRoleRaw($role)
    {
        return DB::select("
            SELECT *
            FROM users
            WHERE role = ?
            ORDER BY id ASC
        ", [$role]);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA USER
    |--------------------------------------------------------------------------
    */
    public static function allRaw()
    {
        return DB::select("
            SELECT *
            FROM users
            ORDER BY id ASC
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH USER
    |--------------------------------------------------------------------------
    */
    public static function insertRaw($data)
    {
        return DB::insert("
            INSERT INTO users (
                name,
                email,
                password,
                role,
                foto,
                created_at,
                updated_at
            ) VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role'] ?? 'user',
            $data['foto'] ?? null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */
    public static function updateRaw($id, $data)
    {
        return DB::update("
            UPDATE users SET
                name = ?,
                email = ?,
                role = ?,
                foto = ?,
                updated_at = NOW()
            WHERE id = ?
        ", [
            $data['name'],
            $data['email'],
            $data['role'] ?? 'user',
            $data['foto'] ?? null,
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD USER
    |--------------------------------------------------------------------------
    */
    public static function updatePasswordRaw($id, $password)
    {
        return DB::update("
            UPDATE users SET
                password = ?,
                updated_at = NOW()
            WHERE id = ?
        ", [
            $password,
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS USER
    |--------------------------------------------------------------------------
    */
    public static function deleteRaw($id)
    {
        return DB::delete("
            DELETE FROM users
            WHERE id = ?
        ", [$id]);
    }
}
