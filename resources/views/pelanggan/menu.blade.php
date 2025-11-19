@extends('layouts.pelanggan')

@section('title', 'Daftar Menu - Tikako')

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Daftar Menu</h1>
        <p class="text-muted">Temukan cita rasa terbaik dari dapur Tikako.</p>
        
        {{-- FILTER KATEGORI --}}
        <div class="d-flex justify-content-center gap-2 flex-wrap mt-4">
            <a href="{{ route('menu.indexPage') }}" 
               class="btn {{ $kategori_aktif == '' ? 'btn-dark' : 'btn-outline-dark' }} px-4">
               Semua
            </a>
            <a href="{{ route('menu.indexPage', ['kategori' => 'Makanan']) }}" 
               class="btn {{ $kategori_aktif == 'Makanan' ? 'btn-dark' : 'btn-outline-dark' }} px-4">
               Makanan
            </a>
            <a href="{{ route('menu.indexPage', ['kategori' => 'Minuman']) }}" 
               class="btn {{ $kategori_aktif == 'Minuman' ? 'btn-dark' : 'btn-outline-dark' }} px-4">
               Minuman
            </a>
            <a href="{{ route('menu.indexPage', ['kategori' => 'Cemilan']) }}" 
               class="btn {{ $kategori_aktif == 'Cemilan' ? 'btn-dark' : 'btn-outline-dark' }} px-4">
               Cemilan
            </a>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- LOGIKA TAMPILAN: MODE GROUP (UNTUK "SEMUA")             --}}
    {{-- ======================================================= --}}
    @if($mode_tampilan == 'group')
        
        @foreach($menus_grouped as $kategori => $items)
            {{-- Judul Kategori --}}
            <div class="mb-4 mt-5">
                <h3 class="fw-bold border-start border-4 border-warning ps-3">{{ $kategori }}</h3>
            </div>

            <div class="row g-4">
                @foreach($items as $menu)
                    {{-- KARTU MENU (LANGSUNG DI SINI) --}}
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm hover-card overflow-hidden">
                            
                            <div class="position-relative">
                                {{-- Link Detail --}}
                                <a href="{{ route('menu.show', $menu->id) }}">
                                    @if($menu->foto)
                                        <img src="{{ asset('storage/' . $menu->foto) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" 
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Tanpa Foto" 
                                             style="height: 200px; object-fit: cover;">
                                    @endif
                                </a>

                                {{-- Badge Favorit --}}
                                @if($menu->is_rekomendasi)
                                    <span class="position-absolute top-0 end-0 bg-warning text-dark badge m-2 shadow-sm">
                                        <i class="bi bi-star-fill"></i> Favorit
                                    </span>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-1 text-truncate">{{ $menu->nama_menu }}</h5>
                                <p class="card-text text-muted small mb-3 text-truncate">
                                    {{ $menu->deskripsi ?? 'Lezat dan nikmat.' }}
                                </p>
                                
                                {{-- Harga & Tombol --}}
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="text-success fw-bold fs-5">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                    
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        {{-- Input Angka Kecil --}}
                                        <input type="number" name="quantity" value="1" min="1" 
                                               class="form-control form-control-sm me-2 text-center border-secondary" 
                                               style="width: 50px;">
                                        {{-- Tombol Pesan --}}
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold text-nowrap">
                                            + Pesan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- AKHIR KARTU MENU --}}
                @endforeach
            </div>
        @endforeach

        @if($menus_grouped->isEmpty())
            <div class="text-center py-5 text-muted">Belum ada menu tersedia saat ini.</div>
        @endif


    {{-- ======================================================= --}}
    {{-- LOGIKA TAMPILAN: MODE LIST (UNTUK FILTER SPESIFIK)      --}}
    {{-- ======================================================= --}}
    @else

        <div class="mb-4 mt-5">
            <h3 class="fw-bold border-start border-4 border-warning ps-3">{{ $kategori_aktif }}</h3>
        </div>
        


        <div class="row g-4">
            @forelse($menus as $menu)
                {{-- KARTU MENU (LANGSUNG DI SINI - COPY PASTE DARI ATAS) --}}
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm hover-card overflow-hidden">
                        
                        <div class="position-relative">
                            <a href="{{ route('menu.show', $menu->id) }}">
                                @if($menu->foto)
                                    <img src="{{ asset('storage/' . $menu->foto) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" 
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Tanpa Foto" 
                                         style="height: 200px; object-fit: cover;">
                                @endif
                            </a>

                            @if($menu->is_rekomendasi)
                                <span class="position-absolute top-0 end-0 bg-warning text-dark badge m-2 shadow-sm">
                                    <i class="bi bi-star-fill"></i> Favorit
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-1 text-truncate">{{ $menu->nama_menu }}</h5>
                            <p class="card-text text-muted small mb-3 text-truncate">
                                {{ $menu->deskripsi ?? 'Lezat dan nikmat.' }}
                            </p>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="text-success fw-bold fs-5">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                
                                <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <input type="number" name="quantity" value="1" min="1" 
                                           class="form-control form-control-sm me-2 text-center border-secondary" 
                                           style="width: 50px;">
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold text-nowrap">
                                        + Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- AKHIR KARTU MENU --}}
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">Belum ada menu untuk kategori ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination hanya muncul di mode list --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $menus->appends(['kategori' => $kategori_aktif])->links() }}
        </div>

    @endif

</div>

{{-- CSS Tambahan --}}
<style>
    .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>

@endsection