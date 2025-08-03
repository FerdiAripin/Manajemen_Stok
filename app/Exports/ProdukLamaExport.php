<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukLamaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Produk::where('status', 'lama')->with('kategori')->get()->map(function ($produk) {
            return [
                'nama_produk' => $produk->nama_produk,
                'kategori' => $produk->kategori->nama_kategori ?? '-',
                'stok_awal' => $produk->stok_awal,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Produk', 'Kategori', 'Stok Awal'];
    }
}
