@extends('layouts.pelanggan')

@section('title', $menu->nama_menu . ' - Tikako')

@section('content')

<div class="container py-5">
    <div class="row align-items-center">
        
        {{-- BAGIAN KIRI: FOTO MENU --}}
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card shadow-lg border-0 overflow-hidden rounded-4">
                {{-- Logika Gambar: Pakai foto asli jika ada, kalau tidak pakai placeholder --}}
                @if ($menu->foto)
                    <img src="{{ asset('storage/' . $menu->foto) }}" 
                         class="w-100" 
                         alt="{{ $menu->nama_menu }}"
                         style="height: 450px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/600x600.png?text=Menu+Tikako" 
                         class="w-100" 
                         alt="Tanpa Foto"
                         style="height: 450px; object-fit: cover;">
                @endif
            </div>
        </div>

        {{-- BAGIAN KANAN: DETAIL & TOMBOL PESAN --}}
        <div class="col-md-6 ps-md-5">
            
            {{-- Badge Kategori & Status --}}
            <div class="mb-3">
                <span class="badge bg-secondary me-1">{{ $menu->kategori }}</span>
                
                @if ($menu->is_rekomendasi)
                    <span class="badge bg-warning text-dark me-1">
                        <i class="bi bi-star-fill me-1"></i> Favorit
                    </span>
                @endif

                @if (!$menu->is_tersedia)
                    <span class="badge bg-danger">Stok Habis</span>
                @endif
            </div>

            {{-- Judul Menu --}}
            <h1 class="display-4 fw-bold mb-2">{{ $menu->nama_menu }}</h1>
            
            {{-- Harga --}}
            <div class="harga fs-2 fw-bold text-success mb-4">
                Rp {{ number_format($menu->harga, 0, ',', '.') }}
            </div>
            
            {{-- Deskripsi --}}
            <h5 class="fw-bold text-dark mb-2">Deskripsi</h5>
            <p class="lead fs-6 text-secondary mb-4" style="line-height: 1.8;">
                {{ $menu->deskripsi ?? 'Belum ada deskripsi lengkap untuk menu ini. Namun kami menjamin rasanya nikmat!' }}
            </p>

            <hr class="my-4 opacity-10">

            {{-- FORM TAMBAH KE KERANJANG --}}
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                
                <div class="d-flex align-items-center gap-3">
                    {{-- Input Jumlah (Qty) --}}
                    <div class="input-group" style="width: 150px;">
                        <span class="input-group-text bg-light border-0 fw-bold text-muted">Jml</span>
                        <input type="number" name="quantity" value="1" min="1" 
                               class="form-control text-center border-light bg-light fw-bold fs-5"
                               {{ !$menu->is_tersedia ? 'disabled' : '' }}>
                    </div>

                    {{-- Tombol Pesan (Cek Stok Dulu) --}}
                    @if($menu->is_tersedia)
                        <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm flex-grow-1 rounded-3">
                            <i class="bi bi-cart-plus-fill me-2"></i> Pesan Sekarang
                        </button>
                    @else
                        <button type="button" disabled class="btn btn-secondary btn-lg px-5 fw-bold flex-grow-1 rounded-3">
                            <i class="bi bi-x-circle me-2"></i> Stok Habis
                        </button>
                    @endif
                </div>
            </form>

            {{-- Tombol Kembali --}}
            <div class="mt-5 pt-3 border-top">
                <a href="{{ route('menu.indexPage') }}" class="text-decoration-none text-muted fw-bold small">
                    <i class="bi bi-arrow-left me-1"></i> KEMBALI KE DAFTAR MENU
                </a>
            </div>
        </div>
    </div>
</div>

@endsection