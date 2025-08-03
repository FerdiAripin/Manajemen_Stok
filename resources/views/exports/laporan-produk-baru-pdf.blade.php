<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Baru</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Laporan Produk Baru</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok Awal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $produk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $produk->stok_awal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
