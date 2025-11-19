@extends('layouts.admin')

@section('title', 'Kritik & Saran - Tikako')

@section('content')

    <h1 class="display-6 fw-bold mb-4">Kritik & Saran</h1>
    <p class="text-muted">Daftar masukan dan ulasan dari pelanggan.</p>

    {{-- Statistik Ringkas --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning bg-gradient text-dark">
                <div class="card-body d-flex align-items-center">
                    <div class="fs-1 me-3"><i class="bi bi-star-fill text-white"></i></div>
                    <div>
                        <h6 class="text-uppercase small fw-bold mb-0">Rata-rata Rating</h6>
                        <h2 class="fw-bold mb-0">
                            {{ number_format($feedbacks->avg('rating'), 1) }} <small class="fs-6">/ 5.0</small>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary bg-gradient text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="fs-1 me-3"><i class="bi bi-chat-quote-fill text-white-50"></i></div>
                    <div>
                        <h6 class="text-uppercase small fw-bold mb-0">Total Masukan</h6>
                        <h2 class="fw-bold mb-0">{{ $feedbacks->total() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL FEEDBACK --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4" style="width: 20%;">Pelanggan</th>
                            <th style="width: 15%;">Rating</th>
                            <th style="width: 50%;">Pesan / Masukan</th>
                            <th style="width: 15%;">Tanggal</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feedbacks as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $item->name }}</div>
                                    <div class="small text-muted">{{ $item->email ?? '-' }}</div>
                                </td>
                                
                                <td>
                                    {{-- Logika Menampilkan Bintang --}}
                                    <div class="text-warning small">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $item->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star text-muted opacity-25"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="small fw-bold text-dark mt-1">
                                        @if($item->rating == 5) Sangat Puas
                                        @elseif($item->rating == 4) Puas
                                        @elseif($item->rating == 3) Cukup
                                        @elseif($item->rating == 2) Kurang
                                        @elseif($item->rating == 1) Kecewa
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <p class="mb-0 text-secondary" style="font-style: italic;">
                                        "{{ Str::limit($item->message, 100) }}"
                                    </p>
                                    @if(strlen($item->message) > 100)
                                        <a href="#" class="small text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">Baca selengkapnya</a>
                                        
                                        {{-- Modal Baca Selengkapnya --}}
                                        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Pesan dari {{ $item->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $item->message }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>

                                <td class="text-muted small">
                                    {{ $item->created_at->format('d M Y') }} <br>
                                    {{ $item->created_at->diffForHumans() }}
                                </td>

                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-chat-square-heart fs-1 opacity-25 mb-2 d-block"></i>
                                    Belum ada masukan dari pelanggan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-end">
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>

@endsection