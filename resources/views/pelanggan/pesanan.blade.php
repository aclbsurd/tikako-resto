@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya - Tikako')

@section('content')

<div class="container py-5">
    <h1 class="display-5 fw-bold text-center mb-5">Riwayat Pesanan</h1>

    @if ($orders->isEmpty())
        {{-- Tampilan Kosong --}}
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No Orders" style="width: 120px; opacity: 0.5;">
            <h4 class="mt-4 text-muted">Belum ada riwayat pesanan</h4>
            <p class="text-secondary">Yuk, mulai pesan makanan favoritmu!</p>
            <a href="{{ route('menu.indexPage') }}" class="btn btn-primary mt-2 px-4 rounded-pill shadow-sm">Lihat Menu</a>
        </div>
    @else
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                @foreach ($orders as $order)
                    @php
                        $statusClass = 'bg-secondary';
                        $statusIcon = 'bi-clock';
                        
                        if ($order->status == 'Diterima') { 
                            $statusClass = 'bg-primary'; 
                            $statusIcon = 'bi-receipt'; 
                        } elseif ($order->status == 'Sedang Dimasak') { 
                            $statusClass = 'bg-warning text-dark'; 
                            $statusIcon = 'bi-fire'; 
                        } elseif ($order->status == 'Selesai') { 
                            $statusClass = 'bg-success'; 
                            $statusIcon = 'bi-check-circle-fill'; 
                        } elseif ($order->status == 'Dibatalkan') { 
                            $statusClass = 'bg-danger'; 
                            $statusIcon = 'bi-x-circle-fill'; 
                        }
                    @endphp
                    
                    <div class="card mb-4 shadow-sm border-0 rounded-3 overflow-hidden">
                        {{-- Header Card --}}
                        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">ID Pesanan</small>
                                <span class="fw-bold">#{{ $order->id }}</span>
                            </div>
                            <div>
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                    <i class="bi {{ $statusIcon }} me-1"></i> {{ $order->status }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body p-4">
                            <div class="row">
                                {{-- Kolom Kiri: Detail Item --}}
                                <div class="col-md-7 border-end-md">
                                    <h6 class="fw-bold text-secondary mb-3">Menu Dipesan</h6>
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($order->details as $detail)
                                            <div class="d-flex align-items-center">
                                                {{-- Gambar Kecil --}}
                                                @if($detail->menu && $detail->menu->foto)
                                                    <img src="{{ asset('storage/' . $detail->menu->foto) }}" 
                                                         class="rounded me-3 shadow-sm" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted small" style="width: 50px; height: 50px;">No Pic</div>
                                                @endif

                                                <div class="flex-grow-1">
                                                    <div class="fw-bold text-dark small">{{ $detail->menu->nama_menu }}</div>
                                                    <div class="text-muted small">
                                                        {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-end small">
                                                    Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Kolom Kanan: Ringkasan & Aksi --}}
                                <div class="col-md-5 ps-md-4 mt-4 mt-md-0 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between mb-2 small">
                                            <span class="text-muted">Tanggal</span>
                                            <span class="fw-bold">{{ $order->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2 small">
                                            <span class="text-muted">Meja</span>
                                            <span class="fw-bold">No. {{ $order->nomor_meja }}</span>
                                        </div>
                                        <hr class="opacity-25 my-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted fw-bold">Total Bayar</span>
                                            <span class="fs-5 fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <form method="POST" action="{{ route('orders.repeat', $order) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                                                <i class="bi bi-arrow-repeat me-2"></i> Pesan Lagi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif
</div>

@endsection