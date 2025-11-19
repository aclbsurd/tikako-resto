@extends('layouts.pelanggan')

@section('title', 'Selamat Datang - Tikako')

@section('content')

    {{-- HERO SECTION --}}
    <div class="position-relative text-center text-white mb-5" 
         style="background-image: url('{{ asset('storage/site_images/tikako_banner.png') }}'); 
                background-size: cover; background-position: center; height: 500px;">
        
        {{-- Overlay Gelap --}}
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
        
        <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100 px-3">
            <h1 class="display-3 fw-bold text-shadow" style="font-family: 'Charm', cursive;">Tikako Caffe & Java Culinary</h1>
            <p class="fs-4 lead text-shadow mb-4">Temukan Keajaiban Tersembunyi di Atas Sungai</p>
            <a href="{{ route('menu.indexPage') }}" class="btn btn-warning btn-lg fw-bold shadow px-5 rounded-pill">
                Pesan Sekarang
            </a>
        </div>
    </div>

    <div class="container">

        {{-- BAGIAN 1: REKOMENDASI KAMI (Carousel) --}}
        @if ($data_rekomendasi->isNotEmpty())
            <div class="text-center mb-4">
                <h2 class="fw-bold">Rekomendasi Chef</h2>
                <p class="text-muted">Menu pilihan terbaik yang wajib kamu coba.</p>
            </div>

            {{-- Carousel Bootstrap --}}
            <div id="carouselRekomendasi" class="carousel slide mb-5 shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($data_rekomendasi as $index => $item)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="d-md-flex bg-white border rounded-4 overflow-hidden">
                                {{-- Gambar Kiri --}}
                                <div class="col-md-6">
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="d-block w-100 object-fit-cover" style="height: 350px;" alt="{{ $item->nama_menu }}">
                                    @else
                                        <img src="https://via.placeholder.com/600x400" class="d-block w-100" style="height: 350px;" alt="Tanpa Foto">
                                    @endif
                                </div>
                                {{-- Teks Kanan --}}
                                <div class="col-md-6 p-5 d-flex flex-column justify-content-center text-md-start text-center">
                                    <span class="badge bg-warning text-dark w-auto align-self-center align-self-md-start mb-2">
                                        <i class="bi bi-star-fill"></i> Favorit
                                    </span>
                                    <h2 class="fw-bold">{{ $item->nama_menu }}</h2>
                                    <p class="text-muted">{{ Str::limit($item->deskripsi, 100) }}</p>
                                    <div class="mt-3">
                                        <h3 class="text-success fw-bold mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</h3>
                                        
                                        <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                                            <a href="{{ route('menu.show', $item->id) }}" class="btn btn-outline-dark rounded-pill px-4">Detail</a>
                                            
                                            {{-- Form Add to Cart Cepat --}}
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $item->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                                    + Pesan Cepat
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Tombol Navigasi Carousel --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRekomendasi" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselRekomendasi" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                </button>
            </div>
        @endif


        {{-- BAGIAN 2: MENU TERBARU (Grid) --}}
        <div class="text-center mt-5 mb-4 pt-4 border-top">
            <h2 class="fw-bold">Menu Terbaru</h2>
            <p class="text-muted">Cicipi hidangan terbaru dari kami.</p>
        </div>

        @if ($data_menu_lainnya->isNotEmpty())
            <div class="row g-4">
                @foreach ($data_menu_lainnya as $item)
                    <div class="col-lg-4 col-md-6">
                        
                        {{-- === KARTU MENU (STYLE SAMA DENGAN HALAMAN MENU) === --}}
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                {{-- Link ke Detail --}}
                                <a href="{{ route('menu.show', $item->id) }}">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->nama_menu }}" 
                                             style="height: 220px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Tanpa Foto" 
                                             style="height: 220px; object-fit: cover;">
                                    @endif
                                </a>
                                
                                {{-- Badge Favorit --}}
                                @if($item->is_rekomendasi)
                                    <span class="position-absolute top-0 end-0 bg-warning text-dark badge m-2">
                                        <i class="bi bi-star-fill"></i> Favorit
                                    </span>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $item->nama_menu }}</h5>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($item->deskripsi ?? 'Lezat dan nikmat.', 50) }}
                                </p>
                                
                                {{-- Bagian Harga & Tombol Pesan (SAMA DENGAN HALAMAN MENU) --}}
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="text-success fw-bold fs-5">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $item->id }}">
                                        {{-- Input Angka Kecil --}}
                                        <input type="number" name="quantity" value="1" min="1" 
                                               class="form-control form-control-sm me-2 text-center" 
                                               style="width: 50px;">
                                        {{-- Tombol Biru + Pesan --}}
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold text-nowrap">
                                            + Pesan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- === END KARTU MENU === --}}

                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5 mb-5">
                <a href="{{ route('menu.indexPage') }}" class="btn btn-outline-dark btn-lg px-5 rounded-pill">
                    Lihat Semua Menu <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>

        @else
            <div class="alert alert-info text-center mt-4">
                Belum ada menu tambahan saat ini.
            </div>
        @endif

    </div>

    {{-- CSS Tambahan --}}
    <style>
        .text-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.7); }
    </style>

@endsection