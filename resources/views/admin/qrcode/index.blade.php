@extends('layouts.admin')

@section('title', 'Generator QR Code Meja')

@section('content')
    <h1 class="display-6 fw-bold mb-4">Generator QR Code</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Buat Stiker Meja</h5>
                    <p class="text-muted small mb-4">
                        Masukkan nomor meja untuk membuat QR Code. 
                        Saat dipindai, pelanggan akan diarahkan ke menu dengan nomor meja otomatis terisi.
                    </p>

                    <form action="{{ route('admin.qrcode.print') }}" method="POST" target="_blank">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Meja</label>
                            <input type="number" name="nomor_meja" class="form-control form-control-lg" placeholder="Contoh: 5" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-qr-code me-2"></i> Generate & Cetak
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="alert alert-info d-flex align-items-start shadow-sm">
                <i class="bi bi-info-circle-fill fs-4 me-3 mt-1"></i>
                <div>
                    <h6 class="fw-bold">Tips Penting!</h6>
                    <p class="small mb-0">
                        Jika masih di localhost, pastikan HP dan Laptop terhubung ke <strong>WiFi yang sama</strong> agar HP bisa membuka link-nya.
                        <br>Jika sudah di-hosting (online), QR Code bisa di-scan dari mana saja.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection