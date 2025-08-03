<?php

// app/Models/Produk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['nama_produk', 'kategori_id', 'stok_awal', 'status'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
