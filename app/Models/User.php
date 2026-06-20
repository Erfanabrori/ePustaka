<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public static function findByEmailRaw($email)
    {
        $rows = DB::select('SELECT * FROM users WHERE email = ? LIMIT 1', [$email]);
        return self::hydrate($rows)->first();
    }

    public static function findRaw($id)
    {
        $rows = DB::select('SELECT * FROM users WHERE id = ? LIMIT 1', [$id]);
        return self::hydrate($rows)->first();
    }

    public static function countRaw()
    {
        $rows = DB::select('SELECT COUNT(*) as cnt FROM users');
        return $rows[0]->cnt ?? 0;
    }

    public static function allByRoleRaw($role)
    {
        $rows = DB::select('SELECT * FROM users WHERE role = ? ORDER BY id ASC', [$role]);
        return self::hydrate($rows);
    }

    public static function allRaw()
    {
        $rows = DB::select('SELECT * FROM users ORDER BY id ASC');
        return self::hydrate($rows);
    }
}
