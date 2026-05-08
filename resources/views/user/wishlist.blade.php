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
    </style>

    <div class="container">
        <h2 class="fw-bold mb-4" style="color: var(--primary)"><i class="bi bi-heart-fill"
                style="color: #ef4444; margin-right: 8px;"></i>Wishlist Buku</h2>

        <div class="card-modern">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>ISBN</th>
                        <th>Tahun Terbit</th>
                        <th>Penerbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishlists as $w)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ optional($w->buku)->judul_buku ?? '-' }}
                            </td>

                            <td>
                                {{ optional($w->buku)->isbn ?? '-' }}
                            </td>

                            <td>
                                {{ optional($w->buku)->tahun_terbit ?? '-' }}
                            </td>

                            <td>
                                {{ optional(optional($w->buku)->penerbit)->nama_penerbit ?? '-' }}
                            </td>

                            <td>
                                <a href="/peminjaman/tambah?item_buku_id={{ $w->buku_id }}" class="btn-primary-custom">
                                    Pinjam
                                </a>

                                <a href="/wishlist/hapus/{{ $w->id }}" class="btn-danger-custom"
                                    onclick="return confirm('Hapus dari wishlist?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Wishlist kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
