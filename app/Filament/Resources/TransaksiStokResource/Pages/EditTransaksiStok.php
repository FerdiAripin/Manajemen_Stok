<?php

namespace App\Filament\Resources\TransaksiStokResource\Pages;

use App\Filament\Resources\TransaksiStokResource;
use App\Models\Produk;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiStok extends EditRecord
{
    protected static string $resource = TransaksiStokResource::class;

    // simpan nilai lama sebelum diedit
    public $originalTipe;
    public $originalJumlah;

    protected function beforeFill(): void
    {
        $this->originalTipe = $this->record->tipe;
        $this->originalJumlah = $this->record->jumlah;
    }

    protected function afterSave(): void
    {
        $transaksi = $this->record;
        $produk = Produk::find($transaksi->produk_id);

        if (!$produk) return;

        // Balikkan stok sesuai nilai lama
        if ($this->originalTipe === 'masuk') {
            $produk->stok_awal -= $this->originalJumlah;
        } elseif ($this->originalTipe === 'keluar') {
            $produk->stok_awal += $this->originalJumlah;
        }

        // Terapkan nilai baru
        if ($transaksi->tipe === 'masuk') {
            $produk->stok_awal += $transaksi->jumlah;
        } elseif ($transaksi->tipe === 'keluar') {
            $produk->stok_awal -= $transaksi->jumlah;
        }

        $produk->save();
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
