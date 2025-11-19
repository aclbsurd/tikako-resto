@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Tikako')

@section('content')

    {{-- Header Halaman --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="display-6 fw-bold">Laporan Penjualan</h1>
            <p class="text-muted mb-0">Ringkasan pendapatan dan daftar transaksi yang sudah selesai.</p>
        </div>
        <div class="mt-3 mt-md-0">
            {{-- TOMBOL DROPDOWN CETAK --}}
            <div class="btn-group shadow-sm">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    {{-- Pilihan Periode Cetak --}}
                    <li><h6 class="dropdown-header">Pilih Periode</h6></li>
                    
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.reports.print', ['period' => '7_days']) }}" target="_blank">
                            7 Hari Terakhir
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.reports.print', ['period' => '30_days']) }}" target="_blank">
                            30 Hari Terakhir
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.reports.print', ['period' => 'this_month']) }}" target="_blank">
                            Bulan Ini
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('admin.reports.print', ['period' => 'all']) }}" target="_blank">
                            Semua Riwayat
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    {{-- Kartu Ringkasan (Summary Card) --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="text-uppercase opacity-75 mb-2">Total Pendapatan Bersih</h6>
                        <h2 class="display-5 fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    </div>
                    <div class="mt-3 pt-3 border-top border-white border-opacity-25">
                        <small class="opacity-75"><i class="bi bi-info-circle me-1"></i> Berdasarkan {{ $completedOrders->count() }} transaksi selesai.</small>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Bagian Kanan: GRAFIK PENJUALAN (CHART) --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100 bg-white">
                
                {{-- HEADER KARTU: Ada Judul & Tombol Filter --}}
                <div class="card-header bg-white border-0 pb-0 pt-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-uppercase text-muted mb-0 small fw-bold">
                        <i class="bi bi-graph-up me-1"></i> {{ $titleChart }}
                    </h6>
                    
                    {{-- GROUP TOMBOL FILTER --}}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.reports.index', ['period' => '7_days']) }}" 
                           class="btn {{ $currentPeriod == '7_days' ? 'btn-dark' : 'btn-outline-light text-secondary' }}">
                           7 Hari
                        </a>
                        <a href="{{ route('admin.reports.index', ['period' => '30_days']) }}" 
                           class="btn {{ $currentPeriod == '30_days' ? 'btn-dark' : 'btn-outline-light text-secondary' }}">
                           30 Hari
                        </a>
                        <a href="{{ route('admin.reports.index', ['period' => 'this_month']) }}" 
                           class="btn {{ $currentPeriod == 'this_month' ? 'btn-dark' : 'btn-outline-light text-secondary' }}">
                           Bulan Ini
                        </a>
                    </div>
                </div>

                <div class="card-body pt-2">
                    {{-- Canvas ini adalah tempat Grafik digambar --}}
                    <canvas id="salesChart" style="max-height: 220px;"></canvas> {{-- Tinggi saya tambah dikit biar lega --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-receipt me-2"></i>Riwayat Transaksi</h5>
            
            {{-- Bagian Filter Pencarian --}}
            <form action="{{ route('admin.reports.index') }}" method="GET" style="width: 250px;">
                
                {{-- PENTING: Simpan filter tanggal saat ini agar tidak reset saat search --}}
                <input type="hidden" name="period" value="{{ $currentPeriod }}">
                
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control border-start-0 ps-0" 
                           placeholder="Cari ID, Meja, atau Nama..." 
                           value="{{ request('search') }}"> {{-- Biar teks yg diketik tidak hilang --}}
                           
                    @if(request('search'))
                        {{-- Tombol Reset (X) muncul kalau sedang mencari --}}
                        <a href="{{ route('admin.reports.index', ['period' => $currentPeriod]) }}" 
                           class="btn btn-outline-secondary border-start-0" 
                           title="Hapus Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0"> 
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">ID Order</th>
                            <th>Tanggal</th>
                            <th>Pemesan</th>
                            <th>Meja</th>
                            <th>Detail Pesanan</th>
                            <th class="text-end pe-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($completedOrders as $order)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                                
                                <td>
                                    <div class="small fw-bold text-dark">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ $order->created_at->format('H:i') }} WIB</div>
                                </td>
                                
                                <td>
                                    @if($order->user)
                                        {{ $order->user->name }}
                                    @else
                                        <span class="text-muted fst-italic">Tamu</span>
                                    @endif
                                </td>

                                <td><span class="badge bg-light text-dark border">{{ $order->nomor_meja }}</span></td>

                                {{-- Kolom Detail Item yang Rapi --}}
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @foreach ($order->details as $detail)
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary rounded-circle me-2" 
                                                      style="width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                                                    {{ $detail->quantity }}
                                                </span>
                                                <span class="small text-dark">{{ $detail->menu->nama_menu }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="text-end pe-4 fw-bold text-success">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-clipboard-x fs-1 opacity-50 d-block mb-2"></i>
                                    Belum ada data penjualan yang selesai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Footer Pagination (Jika nanti pakai pagination) --}}
        {{-- <div class="card-footer bg-white py-3">
             {{ $completedOrders->links() }}
        </div> --}}
    </div>
    {{-- 1. Load Library Chart.js (Wajib Online) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- 2. Konfigurasi Grafik --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Ambil data dari Controller (Dikirim lewat PHP json_encode)
            const labels = {!! json_encode($chartLabels) !!};
            const dataValues = {!! json_encode($chartValues) !!};

            new Chart(ctx, {
                type: 'line', // Jenis Grafik: Garis
                data: {
                    labels: labels, // Tanggal (Sumbu X)
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataValues, // Nominal (Sumbu Y)
                        borderColor: '#198754', // Warna Garis (Hijau Success)
                        backgroundColor: 'rgba(25, 135, 84, 0.1)', // Warna Arsiran bawah
                        borderWidth: 2,
                        tension: 0.4, // Kelengkungan garis (biar smooth)
                        fill: true,   // Arsir area bawah garis
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#198754',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Sembunyikan legend biar bersih
                        tooltip: {
                            callbacks: {
                                // Format Tooltip biar ada Rp-nya
                                label: function(context) {
                                    let value = context.raw;
                                    return ' Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4] }, // Garis putus-putus tipis
                            ticks: { display: false } // Sembunyikan angka sumbu Y biar tidak penuh
                        },
                        x: {
                            grid: { display: false } // Hilangkan garis vertikal
                        }
                    }
                }
            });
        });
    </script>
    
@endsection