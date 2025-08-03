<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiStok extends Model
{
    protected $fillable = [
        'tanggal',
        'produk_id',
        'tipe',
        'jumlah',
        'keterangan',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    protected static function booted(): void
    {
        static::deleting(function ($transaksi) {
            $produk = $transaksi->produk;
            if (!$produk) return;

            if ($transaksi->tipe === 'masuk') {
                $produk->stok_awal -= $transaksi->jumlah;
            } elseif ($transaksi->tipe === 'keluar') {
                $produk->stok_awal += $transaksi->jumlah;
            }

            $produk->save();
        });
    }
}
