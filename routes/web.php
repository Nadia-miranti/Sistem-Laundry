<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;

// Redirect root
Route::get('/', fn() => redirect()->route('login'));

// Auth Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes (Admin & Kasir)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Layanan — semua user bisa index; create/store/edit/update/destroy hanya admin
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::middleware('role:admin')->group(function () {
        Route::get('/layanan/create',        [LayananController::class, 'create'])->name('layanan.create');
        Route::post('/layanan',              [LayananController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{layanan}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{layanan}',     [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{layanan}',  [LayananController::class, 'destroy'])->name('layanan.destroy');
    });

    // Transaksi — Kasir & Admin: melihat transaksi, input transaksi baru, dan melunasi pembayaran
    Route::get('/transaksi',                       [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create',                [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',                      [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::patch('/transaksi/{transaksi}/bayar',   [TransaksiController::class, 'updateStatusBayar'])->name('transaksi.updateStatusBayar');

    // Khusus Admin: Menyelesaikan orderan cucian & Menghapus data transaksi
    Route::middleware('role:admin')->group(function () {
        Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
        Route::delete('/transaksi/{transaksi}',       [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });
});
