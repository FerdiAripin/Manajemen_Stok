<?php


use App\Models\Produk;
use App\Models\TransaksiStok;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProdukLamaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// Export PDF
Route::get('/laporan/produk-lama/pdf', function () {
    $data = Produk::where('status', 'lama')->with('kategori')->get();
    $pdf = Pdf::loadView('exports.laporan-produk-lama-pdf', compact('data'));
    return $pdf->stream('laporan_produk_lama.pdf');
})->name('laporan.produk-lama.pdf');

// Export Excel
Route::get('/laporan/produk-lama/excel', function () {
    return Excel::download(new ProdukLamaExport, 'laporan_produk_lama.xlsx');
})->name('laporan.produk-lama.excel');

// Export PDF Laporan Produk Baru
Route::get('/laporan/produk-baru/pdf', function () {
    $data = Produk::where('status', 'baru')->with('kategori')->get();
    $pdf = Pdf::loadView('exports.laporan-produk-baru-pdf', compact('data'));
    return $pdf->stream('laporan_produk_baru.pdf');
})->name('laporan.produk-baru.pdf');

// Export Excel Laporan Produk Baru
Route::get('/laporan/produk-baru/excel', function () {
    return Excel::download(new \App\Exports\ProdukBaruExport, 'laporan_produk_baru.xlsx');
})->name('laporan.produk-baru.excel');

// PDF Export
Route::get('/laporan/stok/pdf', function () {
    $start = request('start');
    $end = request('end');
    $status = request('status');

    $query = TransaksiStok::with('produk.kategori')
        ->whereBetween('tanggal', [$start, $end]);

    if ($status && $status !== 'semua') {
        $query->whereHas('produk', fn ($q) => $q->where('status', $status));
    }

    $data = $query->get();
    $pdf = Pdf::loadView('exports.laporan-stok-pdf', compact('data', 'start', 'end', 'status'));
    return $pdf->stream('laporan_stok.pdf');
})->name('laporan.stok.pdf');

// Excel Export
Route::get('/laporan/stok/excel', function () {
    $start = request('start');
    $end = request('end');
    $status = request('status');

    return Excel::download(new \App\Exports\LaporanStokExport($start, $end, $status), 'laporan_stok.xlsx');
})->name('laporan.stok.excel');
