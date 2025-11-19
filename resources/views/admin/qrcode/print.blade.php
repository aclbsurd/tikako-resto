<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Meja {{ $nomor_meja }}</title>
    <style>
        @page { size: 10cm 12cm; margin: 0; } /* Ukuran Kertas Stiker Custom */
        body { font-family: sans-serif; text-align: center; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; height: 100vh; }
        
        .sticker-box {
            border: 8px solid #000;
            padding: 30px;
            display: inline-block;
            border-radius: 20px;
            width: 300px;
        }
        .title { font-size: 24px; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 1px; }
        .table-no { font-size: 48px; font-weight: 900; margin: 15px 0; color: #d32f2f; border-top: 2px dashed #ccc; border-bottom: 2px dashed #ccc; padding: 10px 0; }
        .scan-text { font-size: 16px; margin-top: 15px; font-style: italic; color: #555; }
        .brand { margin-top: 20px; font-size: 14px; font-weight: bold; color: #000; text-transform: uppercase; }
        
        /* Area QR Code */
        .qr-area svg { width: 100%; height: auto; }
    </style>
</head>
<body onload="window.print()">
    
    <div class="sticker-box">
        <div class="title">Scan Disini</div>
        
        {{-- Tampilkan SVG QR Code --}}
        <div class="qr-area">
            {!! $qrcode !!}
        </div>

        <div class="table-no">MEJA {{ $nomor_meja }}</div>
        
        <div class="scan-text">
            Buka kamera HP & scan<br>untuk pesan menu.
        </div>
        
        <div class="brand">Tikako Caffe & Java Culinary</div>
    </div>

</body>
</html>