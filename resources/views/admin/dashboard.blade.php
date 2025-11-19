@extends('layouts.admin')

@section('title', 'Dashboard Admin - Tikako')

@section('content')

    <h1 class="display-5 fw-bold mb-4">Dashboard Utama</h1>
    <p class="text-muted">Ringkasan operasional dan kinerja Tikako saat ini.</p>

    {{-- BAGIAN STATISTIK (KPI) --}}
    <div class="row g-3 mb-5">
        
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-uppercase small text-muted">Total Pesanan</h5>
                    <div class="display-4 fw-bold text-primary">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-uppercase small text-muted">Menunggu Dapur</h5>
                    <div class="display-4 fw-bold text-warning">{{ $ordersAwaiting }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-uppercase small text-muted">Pendapatan Bersih</h5>
                    <div class="display-6 fw-bold text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-uppercase small text-muted">Efisiensi Dapur</h5>
                    <div class="display-4 fw-bold text-info">98%</div>
                </div>
            </div>
        </div>

    </div>

    {{-- BAGIAN TABEL MONITORING --}}
    <div class="card shadow-sm mt-5">
        <div class="card-header bg-white fw-bold border-bottom-0 py-3 d-flex justify-content-between align-items-center">
            <span><i class="bi bi-activity me-2"></i>Aktivitas Pesanan Terbaru (Live)</span>
            <span class="badge bg-danger animate-pulse">Live Monitoring</span>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Pemesan</th> {{-- Tambah kolom ini --}}
                        <th>Meja</th>
                        <th>Detail Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                
                {{-- Tambahkan ID untuk Auto Refresh --}}
                <tbody id="dashboard-data">
                    @forelse ($latestOrders as $order)
                        @php
                            $statusClass = '';
                            $badgeColor = 'bg-secondary';
                            if ($order->status == 'Diterima') $badgeColor = 'bg-warning text-dark';
                            elseif ($order->status == 'Sedang Dimasak') $badgeColor = 'bg-primary';
                            elseif ($order->status == 'Selesai') $badgeColor = 'bg-success';
                        @endphp
                        <tr>
                            <td>#{{ $order->id }}</td>
                            
                            {{-- Tampilkan Nama Pemesan --}}
                            <td class="fw-bold text-primary">
                                {{ $order->user->name ?? 'Tamu' }}
                            </td>

                            <td class="fw-bold text-center">{{ $order->nomor_meja }}</td>
                            
                            {{-- Tampilan Item yang Lebih Rapi (Mirip Pesanan Dapur) --}}
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @foreach ($order->details as $detail)
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-dark rounded-circle me-2" style="width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                                                {{ $detail->quantity }}
                                            </span>
                                            <small class="text-muted">{{ $detail->menu->nama_menu }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            
                            <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            
                            <td><span class="badge {{ $badgeColor }} rounded-pill">{{ $order->status }}</span></td>
                            
                            <td class="small text-muted">{{ $order->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada pesanan aktif saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-center py-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Pesanan</a>
        </div>
    </div>

    {{-- Script Auto Refresh Dashboard (Sama seperti Pesanan Dapur) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setInterval(function () {
                updateDashboard();
            }, 15000); // Refresh setiap 15 detik

            function updateDashboard() {
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(html, 'text/html');
                        
                        // Update Tabel
                        var newTable = doc.getElementById('dashboard-data').innerHTML;
                        document.getElementById('dashboard-data').innerHTML = newTable;

                        // Update Kartu Statistik (Opsional: Biar angka di atas ikut berubah)
                        // Kita asumsikan class display-4 cukup unik, atau bisa kasih ID spesifik nanti
                        // Untuk sekarang tabelnya dulu yang penting.
                        
                        console.log('Dashboard updated: ' + new Date().toLocaleTimeString());
                    })
                    .catch(error => console.error('Error refreshing dashboard:', error));
            }
        });
    </script>
@endsection