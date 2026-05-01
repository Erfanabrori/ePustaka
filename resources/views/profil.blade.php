@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #2f4b8f;
        --primary-dark: #1e3a8a;
    }

    body {
        background: #f4f6fb;
    }

    .profil-card {
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .profil-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 40px;
        color: white;
    }

    .input-modern {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .input-modern:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(47,75,143,0.1);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(47,75,143,0.3);
    }

    .info-label {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #1f2937;
        font-size: 16px;
        font-weight: 500;
    }
</style>

<div class="container">

    <h3 class="mb-4 fw-bold" style="color: var(--primary)">👤 Profil Saya</h3>

    <div class="row">
        <!-- Info Profil -->
        <div class="col-md-4">
            <div class="profil-card text-center">
                <div class="profil-header">
                    <div class="avatar-circle">👤</div>
                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <span class="badge bg-primary">{{ $user->role }}</span>
                </div>
                <hr>
                <div class="text-start mt-3">
                    <p class="info-label">Email</p>
                    <p class="info-value">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Form Ganti Password -->
        <div class="col-md-8">
            <div class="profil-card">
                <h5 class="fw-bold mb-4">🔒 Ganti Password</h5>

                <form method="POST" action="/profil/update">
                    @csrf

                    <label class="info-label">Password Baru</label>
                    <input type="password" name="password" class="input-modern"
                           placeholder="Masukkan password baru" required>

                    <label class="info-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="input-modern"
                           placeholder="Konfirmasi password baru" required>

                    <button class="btn-primary-custom">Simpan Password</button>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection
