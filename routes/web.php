<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


// Halaman Utama
Route::get('/', [CustomerMenuController::class, 'index'])->name('beranda');

// Halaman Menu Pelanggan (KEMBALI KE NAMA ASAL)
Route::get('/menu', [CustomerMenuController::class, 'menuPage'])->name('menu.indexPage');
Route::get('/menu/{menu}', [CustomerMenuController::class, 'show'])->name('menu.show');

// Halaman Statis
Route::get('/tentang', [CustomerMenuController::class, 'about'])->name('tentang');
Route::get('/kontak', [CustomerMenuController::class, 'contact'])->name('kontak');

// Login & Register
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [LoginController::class, 'login']); 
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [RegisterController::class, 'register']); 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Pelanggan (Login)
Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.myOrders');
    Route::post('/orders/repeat/{order}', [OrderController::class, 'repeatOrder'])->name('orders.repeat');
    Route::get('/profile', [OrderController::class, 'profile'])->name('profile');
    Route::post('/profile', [OrderController::class, 'updateProfile'])->name('profile.update');
    Route::post('/feedback', [CustomerMenuController::class, 'storeFeedback'])->name('feedback.store');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::delete('/remove', [CartController::class, 'destroy'])->name('cart.remove'); 
    });

    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
});

// Rute Admin
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('menu', MenuController::class); 
    Route::post('menu/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/pesanan/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/orders/{order}/print/{type}', [AdminOrderController::class, 'printStruk'])->name('admin.orders.print');
    Route::get('/reports', [AdminOrderController::class, 'reportsIndex'])->name('admin.reports.index');
    Route::get('/reports/print', [AdminOrderController::class, 'printReport'])->name('admin.reports.print');
    Route::get('/customers', [AdminOrderController::class, 'customersIndex'])->name('admin.customers.index');
    Route::delete('/customers/{user}', [AdminOrderController::class, 'destroyCustomer'])->name('admin.customers.destroy');
    Route::get('/feedback', [AdminOrderController::class, 'feedbackIndex'])->name('admin.feedback.index');
    Route::delete('/feedback/{feedback}', [AdminOrderController::class, 'feedbackDestroy'])->name('admin.feedback.destroy');
    Route::get('/password', [AdminOrderController::class, 'showChangePasswordForm'])->name('admin.password');
    Route::post('/password', [AdminOrderController::class, 'updatePassword'])->name('admin.password.update');
    Route::get('/qrcode', [AdminOrderController::class, 'qrCodeIndex'])->name('admin.qrcode.index');
    Route::post('/qrcode/print', [AdminOrderController::class, 'qrCodePrint'])->name('admin.qrcode.print');
});