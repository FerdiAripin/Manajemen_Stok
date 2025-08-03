<?php

namespace App\Exports;

use App\Models\TransaksiStok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanStokExport implements FromCollection, WithHeadings
{
    protected $start, $end, $status;

    public function __construct($start, $end, $status)
    {
        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
    }

    public function collection()
    {
        $query = TransaksiStok::with('produk.kategori')
            ->whereBetween('tanggal', [$this->start, $this->end]);

        if ($this->status !== 'semua') {
            $query->whereHas('produk', fn ($q) => $q->where('status', $this->status));
        }

        return $query->get()->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'produk' => $item->produk->nama_produk ?? '-',
                'kategori' => $item->produk->kategori->nama_kategori ?? '-',
                'status_produk' => $item->produk->status ?? '-',
                'tipe' => $item->tipe,
                'jumlah' => $item->jumlah,
                'keterangan' => $item->keterangan,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Produk', 'Kategori', 'Status Produk', 'Tipe', 'Jumlah', 'Keterangan'];
    }
}
