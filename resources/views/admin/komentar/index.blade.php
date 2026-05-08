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
        background: #fff;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .btn-custom {
        border-radius: 10px;
        padding: 7px 14px;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
    }

    .btn-info-custom {
        background: #0ea5e9;
        color: #fff;
    }

    .btn-danger-custom {
        background: #ef4444;
        color: #fff;
    }

    .table-modern th {
        background: var(--primary);
        color: #fff;
        white-space: nowrap;
        text-align: center;
    }

    .table-modern td {
        vertical-align: middle;
    }

    .table-modern tr:hover {
        background: #f1f5ff;
    }

    .action-buttons a {
        margin: 2px;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: 0.4s ease;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    .comment-preview {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        color: #666;
    }

    .badge-custom {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-info {
        background: #dbeafe;
        color: #0c4a6e;
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 fade-in">
        <h3 class="fw-bold m-0" style="color: var(--primary)">
            <i class="bi bi-chat-left-text" style="margin-right: 8px;"></i>Manajemen Komentar
        </h3>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- TABLE -->
    <div class="card-modern fade-in">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Buku</th>
                        <th>Komentar</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $d)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                <b>{{ $d->user->name ?? '-' }}</b>
                            </td>
                            <td>
                                <b>{{ $d->buku->judul_buku ?? '-' }}</b>
                            </td>
                            <td>
                                <span class="comment-preview" title="{{ $d->isi_komentar }}">
                                    {{ $d->isi_komentar }}
                                </span>
                            </td>
                            <td class="text-center">
                                <small>{{ $d->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="action-buttons text-center">
                                <a href="/komentar/{{ $d->id }}"
                                   class="btn-custom btn-info-custom">Lihat</a>

                                <a href="/komentar/hapus/{{ $d->id }}"
                                   class="btn-custom btn-danger-custom"
                                   onclick="return confirm('Yakin hapus komentar ini?')">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <span style="color:#888">
                                    <i class="bi bi-inbox" style="margin-right: 6px;"></i>Belum ada komentar
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

<!-- ANIMASI -->
<script>
    const items = document.querySelectorAll('.fade-in');

    window.addEventListener('load', () => {
        items.forEach((el, i) => {
            setTimeout(() => {
                el.classList.add('show');
            }, i * 100);
        });
    });
</script>

@endsection
