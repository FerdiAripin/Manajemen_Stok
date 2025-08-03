<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];

    // relasi jika dibutuhkan
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
