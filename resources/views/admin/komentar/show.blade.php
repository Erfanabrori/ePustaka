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
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .btn-custom {
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        margin-right: 10px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
    }

    .btn-danger-custom {
        background: #ef4444;
        color: #fff;
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

    .info-box {
        background: #f8fafc;
        border-left: 4px solid var(--primary);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .info-label {
        font-weight: 600;
        color: var(--primary);
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-value {
        color: #333;
        font-size: 15px;
    }

    .comment-content {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 10px;
        line-height: 1.6;
        color: #333;
        margin: 20px 0;
    }

    .header-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .header-section {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h3 class="fw-bold m-0" style="color: var(--primary)">
            <i class="bi bi-chat-left-text" style="margin-right: 8px;"></i>Detail Komentar
        </h3>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- CONTENT -->
    <div class="card-modern fade-in">

        <!-- USER INFO -->
        <div class="header-section">
            <div class="info-box">
                <div class="info-label">Pengguna</div>
                <div class="info-value">{{ $komentar->user->name ?? '-' }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Buku</div>
                <div class="info-value">{{ $komentar->buku->judul_buku ?? '-' }}</div>
                </div>
        </div>

        <!-- DATES -->
        <div class="header-section">
            <div class="info-box">
                <div class="info-label">Tanggal Komentar</div>
                <div class="info-value">{{ $komentar->created_at->format('d F Y H:i') }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Terakhir Diupdate</div>
                <div class="info-value">{{ $komentar->updated_at->format('d F Y H:i') }}</div>
            </div>
        </div>

        <!-- COMMENT CONTENT -->
        <div>
            <label style="font-weight: 600; color: var(--primary); display: block; margin-bottom: 10px;">
                Isi Komentar
            </label>
            <div class="comment-content">
                {{ $komentar->isi_komentar }}
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="mt-4">
            <a href="/admin/komentar" class="btn-custom btn-primary-custom">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <a href="/admin/komentar/hapus/{{ $komentar->id }}"
               class="btn-custom btn-danger-custom"
               onclick="return confirm('Yakin hapus komentar ini?')">
               <i class="bi bi-trash"></i> Hapus
            </a>
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
