<!DOCTYPE html>
<html>
<head>
    <title>Cetak Semua Barcode</title>
    <link rel="icon" type="image/png" href="{{ asset('icon16x16.png') }}" sizes="16x16">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .label-container {
            display: inline-block;
            border: 2px dashed #333;
            padding: 15px;
            margin: 10px;
            text-align: center;
            width: 250px;
        }
        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
        .book-title {
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h2 class="text-center mb-4">📚 Label Barcode Buku</h2>

    @foreach($buku as $b)
    <div class="label-container">
        <div class="barcode-text">{{ $b->isbn }}</div>
        <div class="book-title">{{ $b->judul_buku }}</div>
        <div style="font-size: 10px;">{{ $b->nomor_panggil }}</div>
    </div>
    @endforeach

    <script>
        window.print();
    </script>
</body>
</html>
