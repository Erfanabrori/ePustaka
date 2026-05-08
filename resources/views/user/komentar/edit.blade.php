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
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        cursor: pointer;
    }

    .btn-secondary-custom {
        background: #6b7280;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-block;
    }

    .form-control {
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(47, 75, 143, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 8px;
    }
</style>

<div class="container">
    <h2 class="fw-bold mb-4" style="color: var(--primary)">
        <i class="bi bi-pencil-square" style="margin-right: 8px;"></i>Edit Komentar
    </h2>

    <div class="card-modern">
        <form method="POST" action="/komentar/update/{{ $komentar->id }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Buku</label>
                <select name="buku_id" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($buku as $b)
                        <option value="{{ $b->id }}" {{ $komentar->buku_id == $b->id ? 'selected' : '' }}>
                            {{ $b->judul_buku }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Komentar</label>
                <textarea name="komentar" class="form-control" rows="5" required>{{ $komentar->isi_komentar }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Rating (Opsional)</label>
                <input type="number" name="rating" class="form-control" min="1" max="5" placeholder="Rating 1-5"
                       value="{{ $komentar->rating ?? '' }}">
                <small class="text-muted">Berikan rating 1-5 bintang</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>

                <a href="/komentar" class="btn-secondary-custom">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
