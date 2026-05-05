<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit';

    protected $fillable = ['nama_penerbit'];

    // relasi ke buku (optional tapi bagus)
    public function buku()
    {
        return $this->hasMany(Buku::class, 'penerbit_id');
    }
}
