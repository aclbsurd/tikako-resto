@extends('layouts.admin')

@section('title', 'Ganti Password - Admin Panel')

@section('content')

    <h1 class="display-6 fw-bold mb-4">Keamanan Akun</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-key me-2"></i>Ganti Password</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        
                        {{-- Password Lama --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" required>
                            <div class="form-text text-muted">Masukkan password yang Anda gunakan saat ini.</div>
                        </div>

                        <hr class="my-4 border-secondary opacity-10">

                        {{-- Password Baru --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password Baru</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                            @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password Baru --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Ulangi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-save me-2"></i> Simpan Password Baru
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-4 mt-md-0">
            <div class="alert alert-warning shadow-sm border-0">
                <h5 class="alert-heading fw-bold"><i class="bi bi-shield-exclamation me-2"></i>Tips Keamanan</h5>
                <p class="mb-0 small">
                    Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk password yang kuat. 
                    Jangan beritahukan password admin Anda kepada siapa pun.
                </p>
            </div>
        </div>
    </div>

@endsection