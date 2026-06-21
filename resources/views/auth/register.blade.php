<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="icon" type="image/png" href="{{ asset('icon16x16.png') }}" sizes="16x16">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e9ecef;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-login {
            width: 900px;
            margin: 80px auto;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            animation: fadeIn 0.8s ease;
        }

        /* LEFT */
        .left {
            width: 50%;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 60px 40px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideLeft 1s ease;
        }

        .left h1 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .left p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* circle effect */
        .left::before {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 250px;
            height: 250px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }

        /* RIGHT */
        .right {
            width: 50%;
            background: white;
            padding: 50px;
            animation: slideRight 1s ease;
        }

        .right h4 {
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 5px rgba(42,82,152,0.3);
            transform: scale(1.02);
        }

        .btn-register {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 10px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            opacity: 0.95;
        }

        .small-text {
            font-size: 13px;
        }

        /* ANIMATION */
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes slideLeft {
            from {transform: translateX(-50px); opacity: 0;}
            to {transform: translateX(0); opacity: 1;}
        }

        @keyframes slideRight {
            from {transform: translateX(50px); opacity: 0;}
            to {transform: translateX(0); opacity: 1;}
        }
    </style>
</head>
<body>

<div class="container-login">

    <!-- LEFT -->
    <div class="left">
        <h1>DAFTAR</h1>
        <p>
            Bergabung dengan ePustaka untuk mengakses koleksi buku lengkap
            dan menikmati layanan peminjaman dengan mudah.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h4 class="text-center mb-2">Sign up</h4>
        <p class="text-center small-text mb-4">Buat akun baru</p>

        @if(session('success'))
            <div class="alert alert-success p-2">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger p-2">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            </div>

            <button class="btn btn-register w-100 mb-3">
                Daftar
            </button>

            <p class="text-center small-text">
                Sudah punya akun? <a href="/">Login</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>
