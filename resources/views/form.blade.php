<!DOCTYPE html>
<html>

<head>
    <title>Form</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <h1>Form Mahasiswa</h1>

    <form method="POST" action="/form">

        @csrf

        <input type="text" name="nama" placeholder="Nama">

        <button type="submit">
            Simpan
        </button>

    </form>
    <br>
    <br>
    <a href="{{ route('dashboardd') }}">
        Dashboard
    </a>

</body>

</html>
