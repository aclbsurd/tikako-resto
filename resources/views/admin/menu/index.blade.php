@extends('layouts.admin')

@section('title', 'Manajemen Menu - Tikako')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold">Manajemen Menu</h1>
            <p class="text-muted mb-0">Kelola daftar menu yang ditampilkan di halaman pelanggan.</p>
        </div>
        <a href="{{ route('menu.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0"> {{-- align-middle bikin teks rata tengah vertikal --}}
                <thead class="bg-light text-uppercase small text-muted">
                    <tr>
                        <th class="ps-4" style="width: 5%;">ID</th>
                        <th style="width: 15%;">Foto</th>
                        <th style="width: 25%;">Detail Menu</th>
                        <th style="width: 15%;">Harga</th>
                        <th style="width: 15%;">Status</th> {{-- Kolom Baru --}}
                        <th class="text-end pe-4" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse ($menus as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $item->id }}</td>
                            
                            {{-- Kolom Foto (Diperbaiki ukurannya) --}}
                            <td>
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" 
                                         alt="{{ $item->nama_menu }}" 
                                         class="rounded shadow-sm border" 
                                         style="width: 70px; height: 70px; object-fit: cover;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted border" 
                                         style="width: 70px; height: 70px;">
                                        <i class="bi bi-image fs-4"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- Kolom Detail (Nama & Kategori digabung biar rapi) --}}
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $item->nama_menu }}</div>
                                <span class="badge bg-light text-dark border mt-1">
                                    {{ $item->kategori }}
                                </span>
                            </td>

                            <td class="fw-bold text-primary">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                            {{-- KOLOM STATUS (Diubah menjadi Dropdown) --}}
                            <td>
                                <select class="form-select form-select-sm" 
                                        onchange="updateStatusViaDropdown(this)" 
                                        data-id="{{ $item->id }}"
                                        style="min-width: 100px;">
                                    
                                    <option value="1" 
                                            {{ $item->is_tersedia ? 'selected' : '' }} 
                                            class="text-success">
                                        Tersedia
                                    </option>
                                    
                                    <option value="0" 
                                            {{ !$item->is_tersedia ? 'selected' : '' }} 
                                            class="text-danger">
                                        Habis
                                    </option>
                                </select>
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Menu">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> 
                                    
                                    <form action="{{ route('menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus menu {{ $item->nama_menu }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Menu">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="80" class="mb-3 opacity-50" alt="Empty">
                                <br>
                                Belum ada data menu. <br>
                                <a href="{{ route('menu.create') }}" class="text-decoration-none">Tambah menu sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Bagian Tombol Pagination --}}
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-end">
                {{-- Ini akan memunculkan tombol: < 1 2 3 > --}}
                {{ $menus->links() }}
            </div>
        </div>
    </div>
    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Fungsi yang dipanggil saat nilai dropdown berubah
        window.updateStatusViaDropdown = function(selectElement) {
            const menuId = selectElement.dataset.id;
            const newStatus = selectElement.value; // Nilai 1 atau 0
            
            // Perbaikan URL: Menggunakan Blade Helper untuk membuat URL (Wajib!)
            const url = `{{ route('menu.toggle-status', ['menu' => ':menuId']) }}`.replace(':menuId', menuId);
            
            // Tampilkan loading visual di dropdown
            selectElement.classList.add('is-valid');
            selectElement.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken 
                },
                // Kirim status baru dalam body request
                body: JSON.stringify({ status: newStatus }) 
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Beri feedback visual (opsional: bisa pakai alert success)
                    console.log(data.message);
                } else {
                    alert('Gagal mengubah status: ' + (data.message || 'Error tidak diketahui'));
                    // Kembalikan ke nilai sebelum diubah jika gagal
                    selectElement.value = newStatus == 1 ? 0 : 1;
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                alert('Terjadi kesalahan koneksi! Kemungkinan route/token CSRF bermasalah.');
            })
            .finally(() => {
                // Hapus loading dan aktifkan lagi dropdown
                selectElement.classList.remove('is-valid');
                selectElement.disabled = false;
            });
        }
    });
</script>
@endpush
@endsection