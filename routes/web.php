<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResepsionisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HotelController::class, 'index']);

Auth::routes(
    [
        'verify' => true
    ]
);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');

// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('admin/users', UserManagementController::class)->names('admin.users');
    Route::resource('admin/kamar', KamarController::class)->names('admin.kamar');
    Route::resource('admin/fasilitas', FasilitasController::class)->names('admin.fasilitas');
});

// ================== RESEPSIONIS ==================
Route::middleware(['auth', 'role:resepsionis'])->group(function () {
    Route::get('/resepsionis', [ResepsionisController::class, 'index']);
    Route::get('/resepsionis/dashboard', [ResepsionisController::class, 'index'])->name('resepsionis.dashboard');

    Route::get('/resepsionis/fasilitas', function () {
        $fasilitas = \App\Models\Fasilitas::all();
        return view('resepsionis.fasilitas', compact('fasilitas'));
    })->name('resepsionis.fasilitas');

    Route::get('/resepsionis/pemesanan', [ResepsionisController::class, 'pemesanan'])->name('resepsionis.pemesanan');
    Route::post('/resepsionis/konfirmasi/{id}', [ResepsionisController::class, 'konfirmasi'])->name('resepsionis.konfirmasi');
    Route::post('/resepsionis/checkin/{id}', [ResepsionisController::class, 'checkin'])->name('resepsionis.checkin');
    Route::get('/resepsionis/history', [ResepsionisController::class, 'history'])->name('resepsionis.history');

    // Pemesanan detail, checkin, checkout
    Route::get('/resepsionis/pemesanan/{pemesanan}/detail', [PemesananController::class, 'detail'])->name('resepsionis.pemesanan.detail');
    Route::post('/resepsionis/pemesanan/{pemesanan}/checkin', [PemesananController::class, 'checkin'])->name('resepsionis.pemesanan.checkin');
    Route::post('/resepsionis/pemesanan/{pemesanan}/checkout', [PemesananController::class, 'checkout'])->name('resepsionis.pemesanan.checkout');
    Route::post('/resepsionis/checkout/{id}', [ResepsionisController::class, 'checkout'])->name('resepsionis.checkout');
    Route::post('/resepsionis/checkout/{id}', [ResepsionisController::class, 'checkout'])->name('resepsionis.checkout');
    Route::post('/resepsionis/pemesanan/{id}/check-time', [ResepsionisController::class, 'checkPemesananTime'])->name('resepsionis.checktime');

    Route::post('/resepsionis/pemesanan/{pemesanan}/update-status', [PemesananController::class, 'updateStatus'])->name('resepsionis.updateStatus');

    Route::get('/resepsionis/dashboard', [ResepsionisController::class, 'dashboard'])->name('resepsionis.dashboard');

    Route::get('/resepsionis/kwitansi/{id}', [ResepsionisController::class, 'kwitansi'])->name('resepsionis.kwitansi');
    // Route::get('/resepsionis/kwitansi/{id}', [ResepsionisController::class, 'cetakKwitansi'])->name('resepsionis.kwitansi');



});

// ================== USER ==================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/kamar', [UserController::class, 'kamar'])->name('user.kamar');
    Route::get('/user/fasilitas', [FasilitasController::class, 'index'])->name('user.fasilitas');
    Route::get('/fasilitas', [App\Http\Controllers\UserController::class, 'fasilitas'])->name('user.fasilitas');
    Route::get('/pemesanan-saya', [PemesananController::class, 'index'])->name('pemesanan.index');

    Route::post('/pesan', [PemesananController::class, 'store'])->name('pesan.kamar');
    Route::delete('/pemesanan/{pemesanan}/cancel', [PemesananController::class, 'cancelPemesanan'])->name('pemesanan.cancel');
    Route::post('/pemesanan/{id}/pay', [PemesananController::class, 'payPemesanan'])->name('pemesanan.pay');
    Route::get('/pemesanan/{id}/bayar', [PemesananController::class, 'bayar'])->name('pemesanan.bayar');
    Route::get('/pemesanan/{id}/qr', [PemesananController::class, 'showQr'])->name('pembayaran.qr');
    Route::post('/pemesanan/{id}/proses-pembayaran', [PemesananController::class, 'prosesPembayaran'])->name('pembayaran.process');
    Route::post('/pemesanan/{id}/konfirmasi', [PemesananController::class, 'konfirmasiPembayaran'])->name('pembayaran.confirm');
    // Route untuk menampilkan halaman pembayaran
    Route::get('/pemesanan/{id}/bayar', [PemesananController::class, 'showPembayaran'])->name('pemesanan.bayar');


    // Route untuk mengonfirmasi pembayaran
    Route::post('/pembayaran/confirm/{id}', [PemesananController::class, 'confirmPayment'])->name('pembayaran.confirm');

    Route::post('/pemesanan/{id}/upload-bukti-pembayaran', [PemesananController::class, 'uploadBuktiPembayaran'])->name('pemesanan.uploadBuktiPembayaran');

    Route::put('/pemesanan/{pemesanan}/status', [PemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');
});
