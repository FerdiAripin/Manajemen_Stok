<?php

namespace App\Filament\Pages;

use App\Models\Produk;
use Filament\Pages\Page;

class LaporanProdukBaru extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.laporan-produk-baru';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Produk Baru';
    protected static ?int $navigationSort = 2;
    public $produkBaru;

    public function mount(): void
    {
        $this->produkBaru = Produk::where('status', 'baru')->with('kategori')->get();
    }
}
