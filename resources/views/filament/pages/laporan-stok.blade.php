<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Laporan Stok</h2>

    <form wire:submit.prevent="mount">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Awal</label>
                <input type="date"
                       wire:model.live="tanggal_awal"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date"
                       wire:model.live="tanggal_akhir"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select wire:model.live="filter_kategori"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="semua">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Produk</label>
                <select wire:model.live="filter_status"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="semua">Semua</option>
                    <option value="baru">Produk Baru</option>
                    <option value="lama">Produk Lama</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
            <select wire:model.live="filter_produk"
                    class="w-full md:w-1/2 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="semua">Semua Produk</option>
                @foreach($produkList as $produk)
                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2 mb-4">
            <a href="{{ route('laporan.stok.pdf', ['start' => $tanggal_awal, 'end' => $tanggal_akhir, 'status' => $filter_status, 'produk' => $filter_produk, 'kategori' => $filter_kategori]) }}"
               target="_blank"
               class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                Export PDF
            </a>
            <a href="{{ route('laporan.stok.excel', ['start' => $tanggal_awal, 'end' => $tanggal_akhir, 'status' => $filter_status, 'produk' => $filter_produk, 'kategori' => $filter_kategori]) }}"
               class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Export Excel
            </a>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Status Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Jumlah</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($transaksi as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900 border">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border">{{ $item->produk->nama_produk ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border">{{ $item->produk->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($item->produk->status === 'baru') bg-green-100 text-green-800
                                @elseif($item->produk->status === 'lama') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($item->produk->status ?? '-') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($item->tipe === 'masuk') bg-blue-100 text-blue-800
                                @elseif($item->tipe === 'keluar') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($item->tipe) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border font-medium">{{ number_format($item->jumlah) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border">{{ $item->keterangan ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada data transaksi stok ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksi->count() > 0)
        <div class="mt-4 text-sm text-gray-600">
            Total: {{ $transaksi->count() }} transaksi ditemukan
        </div>
    @endif
</x-filament::page>
