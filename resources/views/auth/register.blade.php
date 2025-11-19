@extends('layouts.pelanggan')

@section('title', 'Daftar Akun - Tikako')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10">
            {{-- Card Wrapper --}}
            <div class="card border-0 shadow-lg overflow-hidden rounded-4" style="min-height: 600px;">
                <div class="row g-0 h-100">
                    
                    {{-- ================================================== --}}
                    {{-- BAGIAN KIRI: FORM PENDAFTARAN (Ditaruh di atas)    --}}
                    {{-- ================================================== --}}
                    <div class="col-lg-6 d-flex align-items-center bg-white order-2 order-lg-1">
                        <div class="card-body p-4 p-lg-5">
                            
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-dark">Buat Akun Baru</h3>
                                <p class="text-muted small">Isi data diri Anda untuk mulai memesan.</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                {{-- Input Nama --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-person"></i></span>
                                        <input type="text" name="name" class="form-control bg-light border-start-0 py-2 @error('name') is-invalid @enderror" placeholder="Nama Anda" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Input Email --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control bg-light border-start-0 py-2 @error('email') is-invalid @enderror" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Input Password --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control bg-light border-start-0 py-2 @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                                    </div>
                                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Input Konfirmasi Password --}}
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary">Ulangi Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control bg-light border-start-0 py-2" placeholder="Tulis ulang sandi" required>
                                    </div>
                                </div>

                                {{-- Tombol Daftar --}}
                                <div class="d-grid mb-4 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm py-3 rounded-3">
                                        Daftar Sekarang <i class="bi bi-person-plus ms-2"></i>
                                    </button>
                                </div>

                                {{-- Link ke Login --}}
                                <div class="text-center text-muted small">
                                    Sudah punya akun? 
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">
                                        Masuk disini
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>


                    {{-- ================================================== --}}
                    {{-- BAGIAN KANAN: GAMBAR SUASANA (Ditaruh di bawah)    --}}
                    {{-- ================================================== --}}
                    <div class="col-lg-6 d-none d-lg-block position-relative bg-dark order-1 order-lg-2">
                        <img src="{{ asset('storage/site_images/tikako_banner.png') }}" 
                             class="position-absolute w-100 h-100" 
                             style="object-fit: cover; opacity: 0.8; top: 0; left: 0;" 
                             alt="Register Banner">
                        
                        {{-- Overlay Teks --}}
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-5 text-center" style="background: rgba(0,0,0,0.4); z-index: 2;">
                            <h2 class="fw-bold mb-3 display-6" style="font-family: 'Charm', cursive;">Bergabung Bersama Kami!</h2>
                            <p class="lead fs-6">Nikmati kuliner lezat dengan suasana alam yang menenangkan.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection