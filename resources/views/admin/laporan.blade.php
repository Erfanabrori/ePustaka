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
    </style>

    <div class="container">
        <h2 class="fw-bold mb-4" style="color: var(--primary)">📊 Laporan Transaksi Peminjaman</h2>

        <!-- Filter -->
        <div class="card-modern mb-4">
            <form method="GET" class="d-flex gap-3 align-items-center">
                <select name="bulan" class="form-control" style="width: 150px;">
                    <option value="">-- Bulan --</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
                <select name="tahun" class="form-control" style="width: 150px;">
                    <option value="">-- Tahun --</option>
                    @for($i = 2023; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button class="btn-primary-custom">Filter</button>
                <a href="/laporan/cetak?bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
                   class="btn-primary-custom" target="_blank">Cetak</a>
            </form>
        </div>

        <!-- Tabel Laporan -->
        <div class="card-modern">
            <table class="table table-modern">
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
                            <td>
                                @if($d->tanggal_kembali)
                                    <span class="badge bg-success text-white px-2 py-1 rounded">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark px-2 py-1 rounded">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
