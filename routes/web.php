<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;

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
Route::view('/', 'auth/login');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// kantin
Route::middleware(['auth', 'userAkses:kantin'])->group(function(){
Route::get('/kantin', [DashboardController::class, 'kantinIndex'])->name('kantin.index');
Route::resource('/kantin/kategori', KategoriController::class);
Route::resource('/kantin/produk', ProdukController::class);
//laporan
Route::get('/kantin/laporan-harian', [TransaksiController::class, 'laporanTransaksiHarian'])->name('kantin.laporan');
Route::get('/kantin/transaksi/{invoice}', [TransaksiController::class, 'laporanTransaksi'])->name('transaksi.detail');

});

// Bank
Route::middleware(['auth', 'userAkses:bank'])->group(function () {
    Route::get('/bank', [DashboardController::class, 'bankIndex'])->name('bank.index');

    // Top Up
    Route::get('/bank/topup', [BankController::class, 'bankTopupIndex'])->name('bank.topup');
    Route::put('/bank/konfirmasiTopup/{id}', [BankController::class, 'konfirmasiTopup'])->name('konfirmasi.topup');
    Route::put('/bank/tolakTopup/{id}', [BankController::class, 'tolakTopup'])->name('tolak.topup');

    // Tarik Tunai
    Route::get('/bank/withdrawal', [BankController::class, 'bankWithdrawalIndex'])->name('bank.withdrawal');
    Route::put('/bank/konfirmasiWithdrawal/{id}', [BankController::class, 'konfirmasiWithdrawal'])->name('konfirmasi.withdrawal');
    Route::put('/bank/tolakWithdrawal/{id}', [BankController::class, 'tolakWithdrawal'])->name('tolak.withdrawal');

    //Laporan
    Route::get('/bank/laporan-withdrawal', [BankController::class, 'laporanWithdrawalHarian'])->name('withdrawal.harian');
    Route::get('/bank/laporan-withdrawal/{tanggal}', [BankController::class, 'laporanWithdrawal'])->name('withdrawal.detail');
    Route::get('/bank/laporan', [BankController::class, 'laporanTopupHarian'])->name('topup.harian');
    Route::get('/bank/laporan-topup/{tanggal}', [BankController::class, 'laporanTopup'])->name('topup.detail');
});


// Customer
Route::middleware(['auth', 'userAkses:customer'])->group(function () {
Route::get('/customer', [DashboardController::class, 'customerIndex'])->name('customer.index');
// topup
Route::post('/customer/topup', [BankController::class, 'topup'])->name('topup.request');
// tariktunai
Route::post('/customer/withdrawal', [BankController::class, 'withdrawal'])->name('withdrawal.request');
// transaksi
Route::get('/customer/kantin', [TransaksiController::class, 'customerIndexKantin'])->name('customer.kantin');
Route::post('/customer/tambahKeKeranjang/{id}', [TransaksiController::class, 'addToCart'])->name('addToCart');
Route::get('/customer/keranjang', [TransaksiController::class, 'keranjangIndex'])->name('customer.keranjang');
Route::post('/customer/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
Route::delete('/customer/keranjang/destroy/{id}', [TransaksiController::class, 'keranjangDestroy'])->name('keranjang.destroy');
Route::get('/customer/transaksi/cetak', [TransaksiController::class, 'cetakTransaksi'])->name('cetak.transaksi');
// riwayat
Route::get('/customer/riwayat/transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('customer.riwayat.transaksi');
Route::get('/customer/riwayat/transaksi/{invoice}', [TransaksiController::class, 'detailRiwayatTransaksi'])->name('customer.transaksi.detail');
Route::get('/customer/riwayat/topup', [BankController::class, 'riwayatTopup'])->name('customer.riwayat.topup');
Route::get('/customer/riwayat/withdrawal', [BankController::class, 'riwayatWithdrawal'])->name('customer.riwayat.withdrawal');
});