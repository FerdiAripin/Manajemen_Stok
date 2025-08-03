<?php

namespace App\Filament\Pages;

use App\Models\Produk;
use Filament\Pages\Page;

class LaporanProdukLama extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.laporan-produk-lama';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Produk Lama';
    protected static ?int $navigationSort = 2;

    public $produkLama;

    public function mount(): void
    {
        $this->produkLama = Produk::where('status', 'lama')->with('kategori')->get();
    }
}
