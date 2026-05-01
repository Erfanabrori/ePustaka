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
        <h2 class="fw-bold" style="color: var(--primary)">➕ Tambah Pengguna</h2>
    </div>

    <div class="card-modern">
        <form method="POST" action="/user/simpan">
            @csrf

            <input name="name" class="input-modern" placeholder="Contoh: Muhammad Erfan" required>

            <input name="email" class="input-modern" placeholder="Contoh: user@gmail.com" required>

            <input type="password" name="password" class="input-modern" placeholder="Contoh: password123" required>

            <button class="btn-primary-custom">Simpan</button>
            <a href="/user" class="btn-secondary-custom">Kembali</a>
        </form>
    </div>

</div>

@endsection
