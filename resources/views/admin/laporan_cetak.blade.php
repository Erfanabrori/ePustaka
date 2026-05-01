<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { font-size: 12px; }
    </style>
</head>
<body>
    <h2>📊 Laporan Transaksi Peminjaman</h2>
    <p class="text-center mb-4">Perpustakaan ePustaka</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($d->user)->name ?? '-' }}</td>
                    <td>{{ optional($d->Buku)->judul_buku ?? '-' }}</td>
                    <td>{{ $d->tanggal_pinjam ? \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $d->tanggal_kembali ? \Carbon\Carbon::parse($d->tanggal_kembali)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $d->tanggal_kembali ? 'Selesai' : 'Dipinjam' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>
</html>
