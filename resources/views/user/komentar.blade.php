@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #35539b;
        --primary-dark: #243f82;
        --soft-bg: #f4f6fb;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    body {
        background: var(--soft-bg);
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

    /* CARD */
    .card-modern {
        background: #ffffff;
        border-radius: 26px;
        padding: 26px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        margin-bottom: 25px;
    }

    /* FORM */
    .form-section {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }

    .form-section h5 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 22px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border: 1px solid #dbe1ea;
        padding: 11px 14px;
        font-size: 14px;
    }

    textarea.form-control {
        resize: none;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: none;
    }

    /* BUTTON */
    .btn-primary-custom {
        background: white;
        color: var(--primary);
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
    }

    .btn-warning-custom {
        background: var(--warning);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-danger-custom {
        background: var(--danger);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
    }

    /* TABLE */
    .table-modern {
        margin-bottom: 0;
    }

    .table-modern th {
        background: var(--primary);
        color: white;
        padding: 14px 16px;
        font-size: 14px;
        font-weight: 700;
        border: none;
    }

    .table-modern th:first-child {
        border-top-left-radius: 10px;
    }

    .table-modern th:last-child {
        border-top-right-radius: 10px;
    }

    .table-modern td {
        padding: 16px;
        font-size: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #edf0f5;
    }

    .table-modern tr:hover {
        background: #f8faff;
    }

    /* BADGE */
    .rating-badge {
        background: #6b7280;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
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
        <i></i>
        Komentar & Rating Buku
    </h2>

    <!-- TABLE -->
    <div class="card-modern fade-in">

        <table class="table table-modern">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>Judul Buku</th>
                    <th>Komentar</th>
                    <th width="120">Rating</th>
                    <th width="150">Tanggal</th>
                    <th width="120">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($komentar as $k)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ optional($k->buku)->judul_buku ?? '-' }}
                        </td>

                        <td style="max-width: 350px;">
                            {{ $k->isi_komentar }}
                        </td>

                        <td>

                            @if($k->rating)

                                <span class="rating-badge">
                                    ⭐ {{ $k->rating }}/5
                                </span>

                            @else
                                -
                            @endif

                        </td>

                        <td>
                            {{ $k->created_at->format('d-m-Y') }}
                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="/komentar/edit/{{ $k->id }}"
                                   class="btn-warning-custom">
                                    ✏️
                                </a>

                                <a href="/komentar/hapus/{{ $k->id }}"
                                   class="btn-danger-custom"
                                   onclick="return confirm('Hapus komentar ini?')">
                                    🗑️
                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-box">

                                Belum ada komentar

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- FORM -->
    <div class="card-modern form-section fade-in">

        <h5>
        Tambah Komentar Buku
        </h5>

        <form method="POST" action="/komentar">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Pilih Buku
                    </label>

                    <select name="buku_id" class="form-select" required>

                        <option value="">-- Pilih Buku --</option>

                        @foreach($buku as $b)

                            <option value="{{ $b->id }}">

                                {{ $b->judul_buku }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Rating
                    </label>

                    <select name="rating" class="form-select">

                        <option value="">-- Pilih Rating --</option>
                        <option value="5">⭐⭐⭐⭐⭐ Sangat Bagus</option>
                        <option value="4">⭐⭐⭐⭐ Bagus</option>
                        <option value="3">⭐⭐⭐ Cukup</option>
                        <option value="2">⭐⭐ Kurang</option>
                        <option value="1">⭐ Buruk</option>

                    </select>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Komentar
                </label>

                <textarea name="komentar"
                          rows="4"
                          class="form-control"
                          placeholder="Tulis komentar Anda..."
                          required></textarea>

            </div>

            <button type="submit" class="btn-primary-custom">
                Kirim Komentar
            </button>

        </form>

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
