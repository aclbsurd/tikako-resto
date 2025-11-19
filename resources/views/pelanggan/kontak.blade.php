@extends('layouts.pelanggan')

@section('title', 'Hubungi Kami - Tikako')

@section('content')

<div class="container py-5">
    {{-- Card Besar Pembungkus Semuanya --}}
    <div class="card shadow-lg border-0 overflow-hidden rounded-4">
        <div class="row g-0">
            
            {{-- BAGIAN KIRI: Info Kontak (Background Biru) --}}
                    <div class="col-lg-5 text-white p-5 d-flex flex-column justify-content-center position-relative" 
                          style="background-color: #ffc107; ">
                     <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient opacity-25"></div>
                
                <div class="position-relative z-1">
                    <h2 class="fw-bold mb-4">Hubungi Kami</h2>
                    <p class="mb-5 text-white-50 fs-6">
                        Punya pertanyaan, ingin reservasi, atau sekadar menyapa? Kami siap mendengar dari Anda.
                    </p>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-white bg-opacity-25 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt-fill fs-5 text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Alamat</h6>
                            <p class="mb-0 text-white-50 small">Jl. Raya Tikako No. 123, Banjarnegara, Jawa Tengah</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-white bg-opacity-25 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-whatsapp fs-5 text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">WhatsApp</h6>
                            <p class="mb-0 text-white-50 small">+62 856-0040-5568</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="bg-white bg-opacity-25 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-clock-fill fs-5 text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Jam Operasional</h6>
                            <p class="mb-0 text-white-50 small">Setiap Hari: 10.00 - 22.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN KANAN: Formulir Feedback (Putih) --}}
            <div class="col-lg-7 bg-white p-5">
                <h4 class="fw-bold text-dark mb-2">Kritik & Saran</h4>
                <p class="text-muted small mb-4">Masukan Anda sangat berarti bagi kemajuan Tikako Caffe.</p>

                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-2" placeholder="Nama Anda" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Email (Opsional)</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2" placeholder="email@contoh.com">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Tingkat Kepuasan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-star-fill text-warning"></i></span>
                                <select name="rating" class="form-select bg-light border-0 py-2">
                                    <option value="5">Sangat Puas (5/5)</option>
                                    <option value="4">Puas (4/5)</option>
                                    <option value="3">Cukup (3/5)</option>
                                    <option value="2">Kurang (2/5)</option>
                                    <option value="1">Kecewa (1/5)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Pesan / Masukan</label>
                            <textarea name="message" class="form-control bg-light border-0" rows="5" placeholder="Tuliskan pengalaman Anda di sini..." required></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                Kirim Masukan <i class="bi bi-send ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection