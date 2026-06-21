<!DOCTYPE html>
<html>
<head>
    <title>Cetak Semua Kartu Anggota</title>
    <link rel="icon" type="image/png" href="{{ asset('icon16x16.png') }}" sizes="16x16">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .kartu {
            width: 350px;
            height: 220px;
            border: 3px solid #2f4b8f;
            border-radius: 15px;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe8 100%);
            position: relative;
            display: inline-block;
            margin: 10px;
        }
        .kartu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .kartu-title {
            font-size: 16px;
            font-weight: bold;
            color: #2f4b8f;
        }
        .kartu-foto {
            width: 60px;
            height: 60px;
            background: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .kartu-info {
            margin-top: 10px;
        }
        .kartu-info td {
            padding: 3px 0;
            font-size: 12px;
        }
        .kartu-footer {
            position: absolute;
            bottom: 15px;
            left: 20px;
            right: 20px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <h2 class="text-center mb-4">👥 Kartu Anggota</h2>

    @foreach($data as $user)
    <div class="kartu">
        <div class="kartu-header">
            <div>
                <div class="kartu-title">KARTU ANGGOTA</div>
                <div style="font-size: 12px; color: #666;">ePustaka</div>
            </div>
            <div class="kartu-foto">👤</div>
        </div>

        <table class="kartu-info">
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $user->name }}</td>
            </tr>
            <tr>
                <td><strong>ID Anggota</strong></td>
                <td>: {{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>: {{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Terdaftar</strong></td>
                <td>: {{ $user->created_at->format('d-m-Y') }}</td>
            </tr>
        </table>

        <div class="kartu-footer">
            Perpustakaan ePustaka - Kartu ini berlaku seumur hidup
        </div>
    </div>
    @endforeach

    <script>
        window.print();
    </script>
</body>
</html>
