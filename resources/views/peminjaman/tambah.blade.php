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
        padding: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        max-width: 500px;
        margin: auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
        color: #555;
    }

    .input-modern {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .input-modern:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(47,75,143,0.1);
    }

    .btn-custom {
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 14px;
        border: none;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
    }

    .btn-secondary-custom {
        background: #6b7280;
        color: #fff;
    }

    .info-text {
        font-size: 13px;
        color: #777;
        margin-top: -10px;
        margin-bottom: 15px;
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="mb-4 text-center">
        <h3 class="fw-bold" style="color: var(--primary)">
            📚 Pinjam Buku
        </h3>
        <small style="color:#777">Pilih buku yang ingin kamu pinjam</small>
    </div>

    <!-- FORM -->
    <div class="card-modern">
        <form method="POST" action="/peminjaman/simpan">
            @csrf

            <div class="form-group">
                <label class="label">Pilih Buku</label>
                <select name="buku_id" class="input-modern" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($buku as $b)
                        <option value="{{ $b->id }}">
                            {{ $b->judul_buku }}
                        </option>
                    @endforeach
                </select>
                <div class="info-text">
                    Pastikan buku tersedia sebelum meminjam
                </div>
            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between mt-3">
                <button class="btn-custom btn-primary-custom">
                    Pinjam
                </button>

                <a href="/peminjaman" class="btn-custom btn-secondary-custom">
                    Kembali
                </a>
            </div>

        </form>
    </div>

</div>

@endsection
