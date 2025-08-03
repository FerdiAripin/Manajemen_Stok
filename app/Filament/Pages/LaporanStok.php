<?php

namespace App\Filament\Pages;

use App\Models\TransaksiStok;
use App\Models\Produk;
use App\Models\Kategori;
use Filament\Pages\Page;

class LaporanStok extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.laporan-stok';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Stok';
    protected static ?int $navigationSort = 2;

    public $transaksi;
    public $tanggal_awal;
    public $tanggal_akhir;
    public $filter_status;
    public $filter_produk;
    public $filter_kategori;

    public $produkList = [];
    public $kategoriList = [];

    public function mount(): void
    {
        $this->tanggal_awal = now()->startOfMonth()->toDateString();
        $this->tanggal_akhir = now()->endOfMonth()->toDateString();
        $this->filter_status = 'semua';
        $this->filter_produk = 'semua';
        $this->filter_kategori = 'semua';

        $this->produkList = Produk::all();
        $this->kategoriList = Kategori::all();

        $this->transaksi = $this->getData();
    }

    public function updated($property): void
    {
        // Update produk list when kategori filter changes
        if ($property === 'filter_kategori') {
            $this->updateProdukList();
            // Reset produk filter when kategori changes
            if ($this->filter_kategori !== 'semua') {
                $this->filter_produk = 'semua';
            }
        }

        $this->transaksi = $this->getData();
    }

    public function updateProdukList(): void
    {
        if ($this->filter_kategori === 'semua') {
            $this->produkList = Produk::all();
        } else {
            $this->produkList = Produk::where('kategori_id', $this->filter_kategori)->get();
        }
    }

    public function getData()
    {
        $query = TransaksiStok::with('produk.kategori')
            ->whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir]);

        // Filter by product status
        if ($this->filter_status !== 'semua') {
            $query->whereHas('produk', function ($q) {
                $q->where('status', $this->filter_status);
            });
        }

        // Filter by specific product
        if ($this->filter_produk !== 'semua') {
            $query->where('produk_id', $this->filter_produk);
        }

        // Filter by category
        if ($this->filter_kategori !== 'semua') {
            $query->whereHas('produk', function ($q) {
                $q->where('kategori_id', $this->filter_kategori);
            });
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }
}
