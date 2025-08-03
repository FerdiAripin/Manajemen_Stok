<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Laporan Produk Baru</h2>

    <div class="flex gap-2 mb-4">
        <a href="{{ route('laporan.produk-baru.pdf') }}" target="_blank"
           class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Export PDF
        </a>
        <a href="{{ route('laporan.produk-baru.excel') }}"
           class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Export Excel
        </a>
    </div>

    <table class="w-full table-auto border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">No</th>
                <th class="p-2 border">Nama Produk</th>
                <th class="p-2 border">Kategori</th>
                <th class="p-2 border">Stok Awal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->produkBaru as $index => $produk)
                <tr>
                    <td class="p-2 border">{{ $index + 1 }}</td>
                    <td class="p-2 border">{{ $produk->nama_produk }}</td>
                    <td class="p-2 border">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                    <td class="p-2 border">{{ $produk->stok_awal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament::page>
