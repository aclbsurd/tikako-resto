<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak #{{ $order->id }}</title>
    <style>
        /* 1. PENGATURAN KERTAS (Wajib untuk Thermal Printer) */
        @page {
            size: 58mm auto; /* Lebar 58mm (Standar Struk), Tinggi bebas */
            margin: 0;       /* Hapus margin browser */
        }
        
        body {
            font-family: 'Courier New', Courier, monospace; /* Font ala mesin tik */
            font-size: 10px; /* Ukuran font standar struk */
            margin: 2px;
            color: #000;
            width: 54mm; /* Area cetak aman (58mm - margin) */
        }

        /* 2. UTILITY CLASSES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .d-flex { display: flex; justify-content: space-between; }
        .mb-1 { margin-bottom: 2px; }
        .mb-2 { margin-bottom: 5px; }

        /* Garis Pemisah ala Struk */
        .dashed-line {
            border-bottom: 1px dashed #000;
            margin: 5px 0;
            width: 100%;
        }

        /* 3. KHUSUS MODE DAPUR (Huruf Besar) */
        .kitchen-header {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .table-number {
            font-size: 28px; /* Sangat Besar */
            font-weight: 900;
            border: 3px solid #000;
            display: inline-block;
            padding: 5px 10px;
            margin: 5px 0;
        }
        .kitchen-item {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }
        .qty-badge {
            font-size: 14px;
            background: #000;
            color: #fff;
            padding: 1px 4px;
            margin-right: 5px;
            border-radius: 3px;
        }

        /* Hapus elemen lain saat print */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
{{-- Auto Print saat dibuka --}}
<body onload="window.print()">

    {{-- ================================================== --}}
    {{-- TAMPILAN 1: TIKET DAPUR (KITCHEN DOCKET)           --}}
    {{-- ================================================== --}}
    @if($type == 'dapur')
        
        <div class="text-center">
            <div class="kitchen-header">TIKET DAPUR</div>
            
            {{-- Nomor Meja Raksasa --}}
            <div class="table-number">MEJA {{ $order->nomor_meja }}</div>
            
            <div style="font-size: 10px;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div style="font-size: 10px;">Order #{{ $order->id }} | {{ $order->user->name ?? 'Tamu' }}</div>
        </div>

        <div class="dashed-line" style="border-bottom: 2px solid #000;"></div>

        <div style="margin-top: 10px;">
            @foreach ($order->details as $detail)
                <div class="kitchen-item d-flex align-items-center">
                    <div>
                        {{-- Kuantitas Hitam Putih --}}
                        <span class="qty-badge">{{ $detail->quantity }}x</span>
                        {{-- Nama Menu --}}
                        <span>{{ $detail->menu->nama_menu }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>
        <div class="text-center" style="font-style: italic; margin-top: 10px;">
            *** Mohon segera diproses ***
        </div>


    {{-- ================================================== --}}
    {{-- TAMPILAN 2: STRUK KASIR (RECEIPT)                  --}}
    {{-- ================================================== --}}
    @else

        {{-- Header Toko --}}
        <div class="text-center">
            <h2 style="margin: 0; font-size: 14px;">TIKAKO</h2>
            <p style="margin: 0; font-size: 10px;">Caffe & Culinary</p>
            <p style="margin: 0; font-size: 9px;">Jl. Raya Tikako No. 123, Majalengka</p>
        </div>

        <div class="dashed-line"></div>

        {{-- Info Transaksi --}}
        <div>
            <div class="d-flex">
                <span>{{ $order->created_at->format('d/m/y H:i') }}</span>
                <span>#{{ $order->id }}</span>
            </div>
            <div class="d-flex">
                <span>Plg: {{ $order->user->name ?? 'Umum' }}</span>
                <span>Meja: {{ $order->nomor_meja }}</span>
            </div>
            <div class="d-flex">
                <span>Kasir: Admin</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        {{-- List Menu --}}
        @foreach ($order->details as $detail)
            <div class="mb-2">
                <div class="fw-bold">{{ $detail->menu->nama_menu }}</div>
                <div class="d-flex">
                    <span>{{ $detail->quantity }} x {{ number_format($detail->price, 0, ',', '.') }}</span>
                    <span>{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="dashed-line"></div>

        {{-- Total & Pembayaran --}}
        <div class="d-flex fw-bold" style="font-size: 12px;">
            <span>TOTAL TAGIHAN</span>
            <span>{{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        {{-- Bagian Tunai & Kembali (Dinamis dari Controller) --}}
        <div class="dashed-line"></div>
        
        <div class="d-flex">
            <span>Tunai</span>
            {{-- Menampilkan uang bayar yang dikirim Controller --}}
            <span>{{ number_format($uangBayar, 0, ',', '.') }}</span>
        </div>
        
        <div class="d-flex fw-bold">
            <span>KEMBALI</span>
            {{-- Menampilkan kembalian yang dikirim Controller --}}
            <span>{{ number_format($kembalian, 0, ',', '.') }}</span>
        </div>

        <div class="dashed-line"></div>

        {{-- Footer --}}
        <div class="text-center" style="margin-top: 10px;">
            <p style="margin: 0;">Terima Kasih atas kunjungan Anda!</p>
            <p style="margin: 0;">Wifi: Tikako_Free | Pass: 123456</p>
        </div>

    @endif

</body>
</html>