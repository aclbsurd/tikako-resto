@extends('layouts.pelanggan')

@section('title', 'Tentang Kami - Tikako')

@section('content')

<div class="container py-5">
    
    {{-- BAGIAN 1: CERITA & FOTO --}}
    <div class="row align-items-center mb-5">
        {{-- Foto Suasana (Kiri) --}}
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="position-relative">
                {{-- UPDATE: Mengarah ke folder storage/site_images --}}
                <img src="{{ asset('storage/site_images/tentang.png') }}" 
                     onerror="this.src='https://placehold.co/600x400?text=Foto+Tikako'" 
                     alt="Suasana Tikako" 
                     class="img-fluid rounded-4 shadow-lg w-100"
                     style="object-fit: cover; height: 400px;">
                
                {{-- Kotak Hiasan --}}
                <div class="position-absolute bg-warning rounded-3 shadow-sm" 
                     style="width: 100px; height: 100px; bottom: -20px; right: -20px; z-index: -1;"></div>
                <div class="position-absolute bg-dark rounded-3 shadow-sm" 
                     style="width: 100px; height: 100px; top: -20px; left: -20px; z-index: -1;"></div>
            </div>
        </div>

        {{-- Teks Cerita (Kanan) --}}
        <div class="col-lg-6 ps-lg-5">
            <h5 class="text-warning fw-bold text-uppercase mb-2">Cerita Kami</h5>
            <h1 class="display-5 fw-bold mb-4">Menyatu dengan Alam</h1>
            
            <p class="text-muted lead fs-6">
                Tikako dimulai pada tahun 2021 dan dikenal karena konsepnya yang unik: 
                menggabungkan pengalaman bersantap dengan suasana alam. 
                Pengunjung dapat menikmati hidangan sambil 
                <span class="fw-bold text-dark bg-warning bg-opacity-25 px-1">merendam kaki di aliran sungai yang jernih.</span>
            </p>
            <p class="text-secondary">
                Kami berkomitmen untuk meningkatkan efisiensi layanan melalui sistem pemesanan berbasis web ini. 
                Tujuan kami adalah memberikan kemudahan pemesanan tanpa perlu mendatangi kasir, 
                sehingga meningkatkan kenyamanan pengunjung agar bisa lebih santai menikmati alam.
            </p>
        </div>
    </div>

    {{-- BAGIAN 2: KEUNGGULAN (3 KOLOM) --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4 hover-card">
                <div class="mb-3 text-warning">
                    <i class="bi bi-water fs-1"></i>
                </div>
                <h5 class="fw-bold">Wisata Alam</h5>
                <p class="text-muted small mb-0">
                    Nikmati sensasi kuliner di tengah aliran sungai Desa Kalilunjar yang sejuk dan asri.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4 hover-card">
                <div class="mb-3 text-warning">
                    <i class="bi bi-cup-hot-fill fs-1"></i>
                </div>
                <h5 class="fw-bold">Java Culinary</h5>
                <p class="text-muted small mb-0">
                    Menyajikan cita rasa masakan Jawa otentik dan kopi pilihan yang memanjakan lidah.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4 hover-card">
                <div class="mb-3 text-warning">
                    <i class="bi bi-phone-fill fs-1"></i>
                </div>
                <h5 class="fw-bold">Digital Service</h5>
                <p class="text-muted small mb-0">
                    Pesan makanan langsung dari meja Anda menggunakan sistem web modern kami.
                </p>
            </div>
        </div>
    </div>

    {{-- BAGIAN 3: LOKASI (CTA) --}}
    <div class="bg-dark text-white rounded-4 p-5 text-center position-relative overflow-hidden">
        {{-- Hiasan Background Transparan --}}
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-10" 
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="position-relative z-1">
            <h2 class="fw-bold mb-3">Kunjungi Kami</h2>
            <p class="mb-4 text-white-50">
                Berlokasi di Desa Kalilunjar, Kecamatan Banjarmangu, Kabupaten Banjarnegara.
            </p>
            <a href="https://maps.google.com/?q=Tikako+Caffe" target="_blank" class="btn btn-warning fw-bold px-4 py-2">
                <i class="bi bi-map-fill me-2"></i> Lihat di Google Maps
            </a>
        </div>
    </div>

</div>

{{-- CSS Tambahan untuk Hover Effect --}}
<style>
    .hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>

@endsection