@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #2f4b8f;
            --primary-dark: #1e3a8a;
            --soft-bg: #f4f6fb;
        }

        body {
            background: var(--soft-bg);
        }

        .card-modern {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
        }

        .table-modern th {
            background: var(--primary);
            color: white;
        }

        .table-modern td,
        .table-modern th {
            padding: 12px;
        }

        .table-modern tr:hover {
            background: #f1f5ff;
        }

        .badge-aktif {
            background: #10b981;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-selesai {
            background: #6b7280;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>

    <div class="container">
        <h2 class="fw-bold mb-4" style="color: var(--primary)"><i class="bi bi-clipboard-check" style="margin-right: 8px;"></i>Riwayat Transaksi Peminjaman</h2>

        <div class="card-modern">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($r->buku)->judul_buku ?? '-' }}</td>
                            <td>{{ $r->tanggal_pinjam ? \Carbon\Carbon::parse($r->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $r->tanggal_kembali ? \Carbon\Carbon::parse($r->tanggal_kembali)->format('d-m-Y') : '-' }}</td>
                            <td>
                                @if($r->tanggal_kembali)
                                    <span class="badge-selesai">Selesai</span>
                                @else
                                    <span class="badge-aktif">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
