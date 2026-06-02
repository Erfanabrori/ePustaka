<!DOCTYPE html>
<html>

<head>
    <title>Aplikasi Laravel</title>
</head>

<body>
    <h1>Website Kampus</h1>
    <hr>
    @include('partials.navbar')
    @yield('content')
    <hr>
    <footer>
        Copyright 2026
    </footer>
</body>

</html>
