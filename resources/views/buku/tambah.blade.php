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
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .input-modern {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
    }

    .btn-secondary-custom {
        background: #6b7280;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        margin-left: 10px;
    }
</style>

<div class="container">

    <div class="mb-4">
        <h2 class="fw-bold" style="color: var(--primary)">➕ Tambah Buku</h2>
    </div>

    <div class="card-modern">
        <form method="POST" action="/buku/simpan">
            @csrf


            <input name="judul_buku" class="input-modern" placeholder="Judul Buku" required>
            <input name="sub_judul" class="input-modern" placeholder="Sub Judul">
            <input name="isbn" class="input-modern" placeholder="ISBN">
            <input name="tahun_terbit" class="input-modern" placeholder="Tahun Terbit" type="number">
            <textarea name="deskripsi" class="input-modern" placeholder="Deskripsi"></textarea>
            <input name="jumlah_halaman" class="input-modern" placeholder="Jumlah Halaman" type="number">
            <select name="penerbit_id" class="input-modern" required>
                <option value="">-- Pilih Penerbit --</option>
                @foreach($penerbit as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_penerbit }}</option>
                @endforeach
            </select>
            <input name="tempat_terbit" class="input-modern" placeholder="Tempat Terbit">
            <input name="edisi" class="input-modern" placeholder="Edisi">
            <input name="nomor_panggil" class="input-modern" placeholder="Nomor Panggil">
            <input name="stok" class="input-modern" placeholder="Stok" type="number">

            <button class="btn-primary-custom">Simpan</button>
            <a href="/buku" class="btn-secondary-custom">Kembali</a>
        </form>
    </div>

</div>

@endsection
