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

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .full {
        grid-column: span 2;
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold" style="color: var(--primary)">
            ✏️ Edit Buku
        </h3>
    </div>

    <!-- FORM -->
    <div class="card-modern">
        <form action="{{ url('/buku/update/' . $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label class="label">Judul Buku</label>
                    <input name="judul_buku" class="input-modern"
                        value="{{ $buku->judul_buku }}" required>
                </div>

                <div class="form-group">
                    <label class="label">Sub Judul</label>
                    <input name="sub_judul" class="input-modern"
                        value="{{ $buku->sub_judul }}">
                </div>

                <div class="form-group">
                    <label class="label">ISBN</label>
                    <input name="isbn" class="input-modern"
                        value="{{ $buku->isbn }}">
                </div>

                <div class="form-group">
                    <label class="label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="input-modern"
                        value="{{ $buku->tahun_terbit }}">
                </div>

                <div class="form-group full">
                    <label class="label">Deskripsi</label>
                    <textarea name="deskripsi" class="input-modern">{{ $buku->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label class="label">Jumlah Halaman</label>
                    <input type="number" name="jumlah_halaman" class="input-modern"
                        value="{{ $buku->jumlah_halaman }}">
                </div>

                <div class="form-group">
                    <label class="label">Penerbit</label>
                    <select name="penerbit_id" class="input-modern" required>
                        <option value="">-- Pilih Penerbit --</option>
                        @foreach ($penerbit as $p)
                            <option value="{{ $p->id }}"
                                {{ $buku->penerbit_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_penerbit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="label">Tempat Terbit</label>
                    <input name="tempat_terbit" class="input-modern"
                        value="{{ $buku->tempat_terbit }}">
                </div>

                <div class="form-group">
                    <label class="label">Edisi</label>
                    <input name="edisi" class="input-modern"
                        value="{{ $buku->edisi }}">
                </div>

                <div class="form-group">
                    <label class="label">Nomor Panggil</label>
                    <input name="nomor_panggil" class="input-modern"
                        value="{{ $buku->nomor_panggil }}">
                </div>

                <div class="form-group">
                    <label class="label">Stok</label>
                    <input type="number" name="stok" class="input-modern"
                        value="{{ $buku->stok }}">
                </div>

            </div>

            <!-- BUTTON -->
            <div class="mt-3">
                <button class="btn-custom btn-primary-custom">Update</button>
                <a href="/buku" class="btn-custom btn-secondary-custom">Kembali</a>
            </div>

        </form>
    </div>

</div>
@endsection
