<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Selamat Datang - Tikako Caffe & Java Culinary')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Charm:wght@400;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex; flex-direction: column; min-height: 100vh;
        }
        main { flex: 1; }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding-top: 0.8rem; padding-bottom: 0.8rem;
        }
        .navbar-brand {
            font-family: 'Charm', cursive; font-size: 1.8rem; font-weight: bold; color: #ffc107 !important;
        }
        .nav-link {
            font-weight: 500; color: rgba(255,255,255,0.8) !important; transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: #ffc107 !important; }

        .btn-pesan {
            background-color: #dc3545; color: white; border-radius: 50px; padding: 8px 20px;
            font-weight: 600; border: none; transition: background 0.3s; text-decoration: none;
        }
        .btn-pesan:hover { background-color: #c82333; color: white; }

        .btn-cart {
            background-color: #ffc107; color: #212529; border-radius: 50px; padding: 8px 15px;
            font-weight: bold; text-decoration: none; display: flex; align-items: center;
        }
        .btn-cart:hover { background-color: #e0a800; color: #212529; }

        footer a { text-decoration: none; color: #adb5bd; transition: 0.3s; }
        footer a:hover { color: #ffc107; }
        
        /* Style Toast Notification */
        .toast-container { z-index: 1055; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">Tikako Caffe & Java Culinary</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::routeIs('menu.indexPage*') ? 'active' : '' }}" href="{{ route('menu.indexPage') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('tentang') ? 'active' : '' }}" href="/tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('kontak') ? 'active' : '' }}" href="/kontak">Kontak</a></li>
                    
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('cart.index') }}" class="btn-cart position-relative">
                            <i class="bi bi-cart-fill me-1"></i>
                            @auth <span class="badge bg-danger rounded-pill ms-1">{{ \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') }}</span>
                            @else <span class="badge bg-danger rounded-pill ms-1">0</span> @endauth
                        </a>
                    </li>

                    @guest
                        <li class="nav-item ms-lg-2"><a href="{{ route('login') }}" class="btn-pesan">Masuk</a></li>
                    @else
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="bg-warning text-dark rounded-circle d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.myOrders') }}"><i class="bi bi-receipt me-2"></i> Pesanan Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-dark text-white pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="fw-bold text-warning mb-3" style="font-family: 'Charm', cursive;">Tikako Caffe & Java Culinary</h4>
                    <p class="text-white-50 small">"Temukan Keajaiban Tersembunyi di atas sungai." Kami menyajikan kuliner dengan suasana alam yang unik di Banjarnegara.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Navigasi</h6>
                    <ul class="list-unstyled small">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="{{ route('menu.indexPage') }}">Menu</a></li>
                        <li><a href="/tentang">Tentang Kami</a></li>
                        <li><a href="/kontak">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Kontak</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-warning"></i> Banjarmangu, Banjarnegara</li>
                        <li class="mb-2"><i class="bi bi-whatsapp me-2 text-warning"></i> +62 856-0040-5568</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3">
                        <a href="https://www.instagram.com/tikakocaffejavaculinary/" class="fs-4 text-white-50 hover-warning"><i class="bi bi-instagram"></i></a>
                        <a href="https://api.whatsapp.com/send?phone=6285600405568&fbclid=PAQ0xDSwOHPwdleHRuA2FlbQIxMQBzcnRjBmFwcF9pZA81NjcwNjczNDMzNTI0MjcIY2FsbHNpdGUCMTUAAaeyu9Es13bcil95KM6Unn4Dqy-bAp4B0xrx6l49P7tUTfwRRJl38HavXsXMEg_aem_hxEQgmg0JQlbQu116Q3_bw" class="fs-4 text-white-50 hover-warning"><i class="bi bi-whatsapp"></i></a>
                        <a href="https://www.facebook.com/p/Tikako-Caffe-Java-Culinary-100063900411377/" class="fs-4 text-white-50 hover-warning"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small text-white-50 pb-3">
                {{-- RAHASIA: ID 'secret-door' untuk trigger login admin --}}
                <span id="secret-door" style="cursor: pointer; user-select: none;">
                    &copy; {{ date('Y') }} Tikako Caffe & Java Culinary. All Rights Reserved.
                </span>
            </div>
        </div>
    </footer>

    {{-- TOAST NOTIFICATION (PENGGANTI ALERT) --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        
        {{-- Toast Sukses --}}
        @if(session('success'))
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{-- Toast Error --}}
        @if(session('error'))
            <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script untuk memunculkan Toast secara otomatis saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 4000 }); // Hilang otomatis stlh 4 detik
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
    {{-- Script Rahasia: Klik 3x untuk Masuk Admin --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let clickCount = 0;
            let clickTimer;

            const secretDoor = document.getElementById('secret-door');

            if (secretDoor) {
                secretDoor.addEventListener('click', function() {
                    clickCount++;
                    
                    // Jika sudah klik 3 kali
                    if (clickCount === 3) {
                        // Redirect ke halaman login admin
                        window.location.href = "{{ route('admin.login') }}";
                        // Reset count biar gak double redirect
                        clickCount = 0; 
                    }

                    // Reset hitungan jika tidak klik lagi dalam 1 detik
                    // Jadi harus klik cepat (tik-tik-tik!)
                    clearTimeout(clickTimer);
                    clickTimer = setTimeout(() => {
                        clickCount = 0;
                    }, 1000);
                });
            }
        });
    </script>
    
    @stack('scripts')
    
</body>
</html>