<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        return self::where('email', $email)->first();
    }

    public static function findRaw($id)
    {
        return self::find($id);
    }

    public static function countRaw()
    {
        return self::count();
    }

    public static function allByRoleRaw($role)
    {
        return self::where('role', $role)
            ->orderBy('id', 'asc')
            ->get();
    }

    public static function allRaw()
    {
        return self::orderBy('id', 'asc')->get();
    }
}
