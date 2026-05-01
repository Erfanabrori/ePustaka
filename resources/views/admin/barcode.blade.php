<!DOCTYPE html>
<html>
<head>
    <title>Cetak Barcode - {{ $buku->judul_buku }}</title>
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
    <div class="label-container">
        <div class="barcode-text">{{ $buku->isbn }}</div>
        <div class="book-title">{{ $buku->judul_buku }}</div>
        <div style="font-size: 10px;">{{ $buku->nomor_panggil }}</div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
