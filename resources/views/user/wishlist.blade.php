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

        /* CARD */
        .card-modern {
            background: #ffffff;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* TITLE */
        .page-title {
            color: var(--primary);
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* TABLE */
        .table-modern {
            margin-bottom: 0;
        }

        .table-modern th {
            background: var(--primary);
            color: white;
            padding: 14px 16px;
            border: none;
            font-size: 14px;
            font-weight: 600;
        }

        .table-modern th:first-child {
            border-top-left-radius: 12px;
        }

        .table-modern th:last-child {
            border-top-right-radius: 12px;
        }

        .table-modern td {
            padding: 16px;
            vertical-align: middle;
            font-size: 14px;
            border-bottom: 1px solid #edf0f5;
        }

        .table-modern tr:hover {
            background: #f8faff;
        }

        /* BUTTON */
        .aksi-wrapper {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
        }

        .btn-danger-custom {
            background: #ef4444;
            color: white;
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
        }

        .btn-danger-custom:hover {
            background: #dc2626;
            transform: translateY(-1px);
            color: white;
        }

        /* EMPTY */
        .empty-box {
            text-align: center;
            padding: 40px 0;
            color: #6b7280;
            font-size: 14px;
        }

        /* ANIMATION */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <div class="container">

        <!-- TITLE -->
        <h2 class="page-title fade-in">
            <i class="" style="color: #ef4444;"></i>
            Wishlist Buku
        </h2>

        <!-- TABLE -->
        <div class="card-modern fade-in">

            <table class="table table-modern">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Judul Buku</th>
                        <th>ISBN</th>
                        <th>Tahun Terbit</th>
                        <th>Penerbit</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($wishlists as $w)
                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $w->judul_buku ?? '-' }}
                            </td>

                            <td>
                                {{ $w->isbn ?? '-' }}
                            </td>

                            <td>
                                {{ $w->tahun_terbit ?? '-' }}
                            </td>

                            <td>
                                {{ $w->nama_penerbit ?? '-' }}
                            </td>

                            <td>

                                <div class="aksi-wrapper">

                                    <a href="/peminjaman/tambah?item_buku_id={{ $w->buku_id }}" class="btn-primary-custom">

                                        Pinjam

                                    </a>

                                    <a href="/wishlist/hapus/{{ $w->id }}" class="btn-danger-custom"
                                        onclick="return confirm('Hapus dari wishlist?')">

                                        Hapus

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="empty-box">

                                    Wishlist kosong

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <script>
        const items = document.querySelectorAll('.fade-in');

        window.addEventListener('load', () => {
            items.forEach((el, i) => {
                setTimeout(() => {
                    el.classList.add('show');
                }, i * 120);
            });
        });
    </script>
@endsection
