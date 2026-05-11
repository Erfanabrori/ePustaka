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
        <h2 class="fw-bold mb-4" style="color: var(--primary)"><i class="bi bi-chat-dots-fill" style="margin-right: 8px;"></i>Komentar & Rating Buku</h2>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form Tambah Komentar -->
        <div class="card-modern mb-4">
            <h5 class="mb-3"><i class="bi bi-pencil-fill" style="margin-right: 8px;"></i>Tambah Komentar Buku</h5>
            <form method="POST" action="/komentar">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Buku <span style="color: red;">*</span></label>
                    <select name="buku_id" class="form-control" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->id }}" {{ (old('buku_id') == $b->id || (isset($selectedBukuId) && $selectedBukuId == $b->id)) ? 'selected' : '' }}>
                                {{ $b->judul_buku }} - {{ $b->penulis ?? 'Unknown' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Komentar <span style="color: red;">*</span></label>
                    <textarea name="komentar" class="form-control" rows="4" placeholder="Tulis komentar Anda tentang buku ini..." required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rating (Opsional)</label>
                        <div class="rating-input">
                            <select name="rating" class="form-control">
                                <option value="">-- Pilih Rating --</option>
                                <option value="5">⭐⭐⭐⭐⭐ Sangat Bagus (5)</option>
                                <option value="4">⭐⭐⭐⭐ Bagus (4)</option>
                                <option value="3">⭐⭐⭐ Cukup (3)</option>
                                <option value="2">⭐⭐ Kurang (2)</option>
                                <option value="1">⭐ Buruk (1)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="bi bi-send-fill" style="margin-right: 6px;"></i>Kirim Komentar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Komentar -->
        <div class="card-modern">
            <h5 class="mb-3"><i class="bi bi-chat-dots" style="margin-right: 8px;"></i>Komentar Saya ({{ count($komentar) }})</h5>

            @forelse($komentar as $k)
                <div style="border-bottom: 1px solid #e5e7eb; padding: 15px 0; margin-bottom: 15px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1" style="color: var(--primary);">{{ optional($k->buku)->judul_buku ?? '-' }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar-event"></i> {{ $k->created_at->format('d M Y') }}
                                @if($k->rating)
                                    <span style="margin-left: 10px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $k->rating)
                                                <span class="rating-star">⭐</span>
                                            @else
                                                <span style="color: #d1d5db;">⭐</span>
                                            @endif
                                        @endfor
                                    </span>
                                @endif
                            </small>
                        </div>
                        <div>
                            <a href="/komentar/edit/{{ $k->id }}"
                                class="btn-warning-custom"
                                style="background: #f59e0b; color: white; padding: 6px 12px; border-radius: 8px; text-decoration: none; display: inline-block; font-size: 12px;">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="/komentar/hapus/{{ $k->id }}"
                                class="btn-danger-custom"
                                style="font-size: 12px;"
                                onclick="return confirm('Hapus komentar ini?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </div>
                    <p style="margin: 10px 0; line-height: 1.6;">{{ $k->isi_komentar }}</p>
                </div>
            @empty
                <div class="text-center" style="padding: 40px 0;">
                    <i class="bi bi-chat-dots-fill" style="font-size: 48px; color: #d1d5db;"></i>
                    <p class="text-muted mt-3">Belum ada komentar. Tulis komentar pertama Anda tentang sebuah buku!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
