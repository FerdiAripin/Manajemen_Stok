<?php

namespace App\Filament\Resources\TransaksiStokResource\Pages;

use App\Filament\Resources\TransaksiStokResource;
use App\Models\Produk;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksiStok extends CreateRecord
{
    protected static string $resource = TransaksiStokResource::class;

    protected function afterCreate(): void
    {
        $transaksi = $this->record;

        // Ambil produk terkait
        $produk = Produk::find($transaksi->produk_id);

        if ($produk) {
            if ($transaksi->tipe === 'masuk') {
                $produk->stok_awal += $transaksi->jumlah;
            } elseif ($transaksi->tipe === 'keluar') {
                $produk->stok_awal -= $transaksi->jumlah;
            }

            $produk->save();
        }
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
