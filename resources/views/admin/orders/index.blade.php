@extends('layouts.admin')

@section('title', 'Manajemen Pesanan - Tikako')

@section('content')
    
    <order-monitor></order-monitor> 
    
    <h1 class="display-6 fw-bold mb-4">Manajemen Pesanan</h1>
    <p class="text-muted">Daftar semua pesanan yang masuk. Pesanan terbaru ada di atas.</p>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0"> 
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pemesan</th> <th>Nomor Meja</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Waktu Pesan</th>
                        <th>Detail Item</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                {{-- ID untuk Auto Refresh --}}
                <tbody id="order-data">
                    @forelse ($data_pesanan as $order)
                        @php
                            $statusClass = ''; 
                            $badgeColor = 'bg-secondary';

                            if ($order->status == 'Diterima') {
                                $statusClass = 'status-diterima'; 
                                $badgeColor = 'bg-warning text-dark';
                            } elseif ($order->status == 'Sedang Dimasak') {
                                $statusClass = 'status-sedang-dimasak';
                                $badgeColor = 'bg-primary';
                            } elseif ($order->status == 'Selesai') {
                                $statusClass = 'status-selesai';
                                $badgeColor = 'bg-success';
                            } elseif ($order->status == 'Dibatalkan') {
                                $statusClass = 'status-dibatalkan';
                                $badgeColor = 'bg-secondary';
                            }
                        @endphp

                        <tr class="{{ $statusClass }} align-middle">
                            <td>#{{ $order->id }}</td>
                            
                            <td>
                                @if($order->user)
                                    <div class="fw-bold">{{ $order->user->name }}</div>
                                @else
                                    <span class="text-muted small fst-italic">Tamu</span>
                                @endif
                            </td> 
                            
                            <td class="text-center fw-bold">{{ $order->nomor_meja }}</td>
                            
                            <td><span class="badge {{ $badgeColor }} rounded-pill">{{ $order->status }}</span></td> 
                            
                            <td class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            
                            <td>
                                <div class="small text-muted">
                                    <i class="bi bi-clock"></i> {{ $order->created_at->format('H:i') }}
                                </div>
                                <div class="small text-muted fst-italic">
                                    {{ $order->created_at->diffForHumans() }}
                                </div>
                            </td>
                            
                            {{-- Tampilan Detail Menu yang Rapi --}}
                            <td style="min-width: 250px;">
                                <div class="d-flex flex-column gap-2">
                                    @foreach ($order->details as $detail)
                                        <div class="d-flex align-items-center p-1 border rounded bg-white shadow-sm">
                                            <div class="badge bg-dark text-white me-2 p-2 rounded-circle" style="width: 30px; height: 30px; display:flex; align-items:center; justify-content:center;">
                                                {{ $detail->quantity }}
                                            </div>
                                            <div class="lh-1">
                                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                    {{ $detail->menu->nama_menu }}
                                                </div>
                                                <small class="text-muted">
                                                    @ Rp {{ number_format($detail->price, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            {{-- Bagian Tombol Aksi --}}
                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mb-2">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select form-select-sm" style="max-width: 110px;">
                                            <option value="Diterima" {{ $order->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="Sedang Dimasak" {{ $order->status == 'Sedang Dimasak' ? 'selected' : '' }}>Dimasak</option>
                                            <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check-lg"></i></button> 
                                    </div>
                                </form>
                                
                                <div class="d-flex gap-1">
                                    {{-- Tombol Print Kasir (MEMANGGIL POPUP MODAL) --}}
                                    <button type="button" 
                                            class="btn btn-sm btn-light border shadow-sm flex-fill" 
                                            title="Struk Kasir"
                                            onclick="showPaymentModal({{ $order->id }}, {{ $order->total_price }})">
                                        <i class="bi bi-receipt"></i> Kasir
                                    </button>
                                    
                                    {{-- Tombol Print Dapur (Langsung Print) --}}
                                    <a href="{{ route('admin.orders.print', ['order' => $order->id, 'type' => 'dapur']) }}" target="_blank" class="btn btn-sm btn-dark shadow-sm flex-fill" title="Tiket Dapur">
                                        <i class="bi bi-egg-fried"></i> Dapur
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                Belum ada pesanan yang masuk hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tombol Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $data_pesanan->links() }}
    </div>

    {{-- ================================================= --}}
    {{-- MODAL POPUP HITUNG PEMBAYARAN --}}
    {{-- ================================================= --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h6 class="modal-title fw-bold">Hitung Pembayaran</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Form Input --}}
                    <div class="mb-2">
                        <label class="small text-muted">Total Tagihan</label>
                        <div class="fs-4 fw-bold text-primary" id="modalTotalDisplay">Rp 0</div>
                        <input type="hidden" id="modalTotalValue">
                        <input type="hidden" id="modalOrderId">
                    </div>
                    
                    <div class="mb-3">
                        <label class="small fw-bold">Uang Diterima (Tunai)</label>
                        <input type="number" class="form-control form-control-lg" id="inputBayar" placeholder="0" oninput="hitungKembalian()">
                    </div>
    
                    <div class="d-flex justify-content-between border-top pt-2">
                        <span class="fw-bold">Kembali:</span>
                        <span class="fw-bold text-success" id="displayKembalian">Rp 0</span>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-primary w-100" onclick="prosesCetak()">
                        <i class="bi bi-printer-fill me-1"></i> Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================= --}}
    {{-- SCRIPT JAVASCRIPT --}}
    {{-- ================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // ----------------------------------------
            // 1. LOGIKA AUTO REFRESH TABEL (15 Detik)
            // ----------------------------------------
            setInterval(function () {
                updateOrderTable();
            }, 15000); 

            function updateOrderTable() {
                var url = window.location.href;
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(html, 'text/html');
                        var newTbody = doc.getElementById('order-data').innerHTML;
                        document.getElementById('order-data').innerHTML = newTbody;
                        console.log('Data pesanan diperbarui: ' + new Date().toLocaleTimeString());
                    })
                    .catch(error => console.error('Gagal update data:', error));
            }
        });

        // ----------------------------------------
        // 2. LOGIKA POPUP KASIR (Global Function)
        // ----------------------------------------
        
        // Tampilkan Modal
        function showPaymentModal(orderId, totalPrice) {
            document.getElementById('modalOrderId').value = orderId;
            document.getElementById('modalTotalValue').value = totalPrice;
            
            // Format Rupiah
            document.getElementById('modalTotalDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
            
            // Reset form
            document.getElementById('inputBayar').value = ''; 
            document.getElementById('displayKembalian').innerText = 'Rp 0';
            document.getElementById('displayKembalian').classList.remove('text-danger');
            document.getElementById('displayKembalian').classList.add('text-success');
            
            var myModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            myModal.show();

            setTimeout(() => { document.getElementById('inputBayar').focus(); }, 500);
        }

        // Hitung Kembalian
        function hitungKembalian() {
            let total = parseInt(document.getElementById('modalTotalValue').value);
            let bayar = parseInt(document.getElementById('inputBayar').value) || 0;
            
            let kembali = bayar - total;

            if (kembali < 0) {
                document.getElementById('displayKembalian').innerText = '- Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(kembali)) + ' (Kurang)';
                document.getElementById('displayKembalian').classList.add('text-danger');
                document.getElementById('displayKembalian').classList.remove('text-success');
            } else {
                document.getElementById('displayKembalian').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembali);
                document.getElementById('displayKembalian').classList.remove('text-danger');
                document.getElementById('displayKembalian').classList.add('text-success');
            }
        }

        // Proses Cetak
        function prosesCetak() {
            let orderId = document.getElementById('modalOrderId').value;
            let bayar = document.getElementById('inputBayar').value;
            let total = document.getElementById('modalTotalValue').value;
            let kembali = bayar - total;

            if (!bayar || bayar < 1) {
                bayar = total; // Default uang pas
                kembali = 0;
            }

            let url = `/admin/orders/${orderId}/print/kasir?bayar=${bayar}&kembali=${kembali}`;
            
            window.open(url, '_blank');
            
            // Opsional: Tutup modal setelah print
            // var modalEl = document.getElementById('paymentModal');
            // var modal = bootstrap.Modal.getInstance(modalEl);
            // modal.hide();
        }
    </script>
@endsection