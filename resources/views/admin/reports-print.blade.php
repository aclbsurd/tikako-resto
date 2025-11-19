<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- PERBAIKAN DI SINI: Jangan pakai $order->id, pakai Tanggal saja --}}
    <title>Laporan Penjualan - {{ date('d M Y') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }
        .header-print { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header-print h1 { font-size: 18pt; font-weight: bold; margin: 0; }
        .summary-section { border: 1px solid #000; padding: 15px; margin-bottom: 30px; background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000 !important; padding: 8px; vertical-align: top; }
        thead th { background-color: #e9ecef !important; color: #000 !important; -webkit-print-color-adjust: exact; }
        .signature-section { margin-top: 50px; page-break-inside: avoid; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>

    <div class="no-print position-fixed top-0 end-0 p-3">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-2">Print</button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm">Tutup</button>
    </div>

    <div class="header-print">
        <h1>TIKAKO CAFFE & CULINARY</h1>
        <p class="mb-0">Jl. Raya Tikako No. 123, Majalengka</p>
        <small>Laporan Penjualan Resmi</small>
    </div>
    {{-- Tampilkan Judul Dinamis --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold text-decoration-underline mb-1">LAPORAN PENJUALAN</h4>
        <p class="text-uppercase small fw-bold text-muted">Periode: {{ $titlePeriod }}</p>
    </div>    
    {{-- RINGKASAN --}}
    <div class="summary-section row">
        <div class="col-6 text-center border-end border-dark">
            <small class="text-uppercase fw-bold">Total Transaksi</small>
            {{-- Pastikan variabel ini dikirim dari Controller --}}
            <div class="fs-3 fw-bold">{{ $completedOrders->count() }}</div>
        </div>
        <div class="col-6 text-center">
            <small class="text-uppercase fw-bold">Total Pendapatan</small>
            <div class="fs-3 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="mb-2">
        <strong>Dicetak pada:</strong> {{ date('d F Y, H:i') }} WIB
    </div>

    <table class="table table-sm">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Meja / Pemesan</th>
                <th style="width: 40%;">Rincian Item</th>
                <th style="width: 20%;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            {{-- LOOPING DATA --}}
            {{-- Variabel $order BARU DIDEFINISIKAN DI SINI --}}
            @forelse ($completedOrders as $index => $order)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        {{ $order->created_at->format('d/m/Y') }} <br>
                        <small>{{ $order->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <strong>Meja {{ $order->nomor_meja }}</strong> <br>
                        <small>{{ $order->user->name ?? 'Tamu' }}</small>
                    </td>
                    <td>
                        <ul class="list-unstyled mb-0 small">
                            @foreach ($order->details as $detail)
                                <li>{{ $detail->quantity }}x {{ $detail->menu->nama_menu }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-end fw-bold">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-3">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signature-section row">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p class="mb-5">
                Majalengka, {{ date('d F Y') }} <br>
                Mengetahui,
            </p>
            <br><br>
            <p class="fw-bold text-decoration-underline">( Manager Operasional )</p>
        </div>
    </div>

    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>