<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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

        .btn-login {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 10px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
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
        <h1>ePustaka</h1>

        <p>
            Selamat datang di Sistem manajemen perpustakaan modern untuk membantu
            pengelolaan buku, peminjaman, dan anggota dengan lebih efisien.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h4 class="text-center mb-2">Sign in</h4>
        <p class="text-center small-text mb-4">Masuk ke akun anda</p>

        @if(session('error'))
            <div class="alert alert-danger p-2">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <div class="d-flex justify-content-between small-text mb-3">
                <div>
                    <input type="checkbox"> Remember
                </div>
                <a href="#">Lupa?</a>
            </div>

            <button class="btn btn-login w-100 mb-3">
                Sign in
            </button>

            <p class="text-center small-text">
                Belum punya akun? <a href="/register">Daftar</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>
