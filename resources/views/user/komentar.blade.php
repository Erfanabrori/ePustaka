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
        }

        .btn-danger-custom {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
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

        .rating-star {
            color: #f59e0b;
        }
    </style>

    <div class="container">
        <h2 class="fw-bold mb-4" style="color: var(--primary)">💬 Komentar & Rating Buku</h2>

        <!-- Form Tambah Komentar -->
        <div class="card-modern mb-4">
            <h5 class="mb-3">Tambah Komentar</h5>
            <form method="POST" action="/komentar">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <select name="buku_id" class="form-control" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id }}">{{ $b->judul_buku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="rating" class="form-control" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="komentar" class="form-control" placeholder="Tulis komentar..." required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-primary-custom w-100">Kirim</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Komentar -->
        <div class="card-modern">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Komentar</th>
                        <th>Rating</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($komentar as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($k->buku)->judul_buku ?? '-' }}</td>
                            <td>{{ $k->komentar }}</td>
                            <td>
                                @for($i = 0; $i < $k->rating; $i++)
                                    ⭐
                                @endfor
                            </td>
                            <td>{{ $k->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="/komentar/hapus/{{ $k->id }}" class="btn-danger-custom"
                                    onclick="return confirm('Hapus komentar?')">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada komentar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
