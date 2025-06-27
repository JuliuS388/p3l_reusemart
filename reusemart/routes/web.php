<?php
use App\Http\Controllers\TukarMerchandiseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\RequestDonasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanKomisiController;
use App\Http\Controllers\LaporanStokGudangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenitipController;

Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    $pembeli = session('pembeli'); // hanya akan bernilai jika role-nya 'pembeli'
    return view('pembeli.dashboard', compact('pembeli'));
})->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::get('/profil', [PembeliController::class, 'profil'])->name('pembeli.profil');
Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
Route::post('/beri-rating/{id}', [PembeliController::class, 'beriRating'])->name('pembeli.beriRating');



Route::resource('pegawai', PegawaiController::class);

Route::get('/', [MainPageController::class, 'index'])->name('home');
Route::get('/produk/{id}', [MainPageController::class, 'showPublic'])->name('main_page.show');

Route::get('/request-donasi', [RequestDonasiController::class, 'index'])->name('request-donasi.index');
Route::post('/request-donasi/accept/{id}', [RequestDonasiController::class, 'storeDonasi'])->name('request-donasi.store-donasi');
Route::get('/histori-donasi', [RequestDonasiController::class, 'historiDonasi'])->name('donasi.histori');
Route::post('/donasi/update/{id}', [RequestDonasiController::class, 'updateDonasi'])->name('donasi.update');

Route::get('/laporan-penjualan', [LaporanController::class, 'index'])->name('laporan.penjualan');
Route::get('/laporan/penjualan', [LaporanController::class, 'index'])->name('laporan.penjualan.index');
Route::get('/laporan/penjualan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.penjualan.pdf');
Route::get('/laporan/penjualan/preview', [LaporanController::class, 'previewPdf'])->name('laporan.penjualan.preview');

Route::get('/laporan/komisi', [LaporanKomisiController::class, 'index'])->name('laporan.komisi');
Route::get('/laporan/komisi', [LaporanKomisiController::class, 'index'])->name('laporan.komisi.index');
Route::get('/laporan/komisi/pdf', [LaporanKomisiController::class, 'cetakPDF'])->name('laporan.komisi.pdf');
Route::get('/laporan/komisi/preview', function () {
    return view('laporan.komisi_preview');
})->name('laporan.komisi.preview');

Route::get('/laporan/stok-gudang', [LaporanStokGudangController::class, 'stokGudang'])->name('laporan.stokgudang');
Route::get('/laporan/stok-gudang/pdf', [LaporanStokGudangController::class, 'stokGudangPdf'])->name('laporan.stokgudang.pdf');
Route::get('/laporan/stok-gudang/preview', [LaporanStokGudangController::class, 'previewStokGudang'])->name('laporan.stokgudang.preview');






Route::resource('barang', BarangController::class);
Route::get('/barang/{id}/nota/view-pdf', [BarangController::class, 'viewPdfNota'])->name('barang.viewPdfNota');

Route::get('/barang/nota-preview-penitip/{id}', [BarangController::class, 'previewNotaPenitip'])->name('barang.previewNotaPenitip');
Route::get('/barang/nota-cetak-penitip/{id}', [BarangController::class, 'cetakNotaPenitip'])->name('barang.cetakNotaPenitip');

Route::get('/barang/expired', [BarangController::class, 'expired'])->name('barang.expired');
Route::put('/barang/{id}/update-to-donation', [BarangController::class, 'updateToDonation'])->name('barang.update-to-donation');
Route::put('/barang/update-all-to-donation', [BarangController::class, 'updateAllToDonation'])->name('barang.update-all-to-donation');

Route::get('/tukarmerch', [TukarMerchandiseController::class, 'index'])->name('tukarmerch.index');
Route::post('/tukarmerch/update/{id}', [TukarMerchandiseController::class, 'update'])->name('tukarmerch.update');
    
Route::get('/admin/top-seller', [AdminController::class, 'topSellerManagement'])->name('admin.top-seller');
Route::post('/admin/top-seller/update', [AdminController::class, 'updateTopSeller'])->name('admin.top-seller.update');
Route::post('/admin/top-seller/add-points', [AdminController::class, 'addPointsToTopSeller'])->name('admin.top-seller.add-points');

Route::get('/admin/expired-items', [AdminController::class, 'expiredItems'])->name('admin.expired-items');
Route::post('/admin/expired-items/update', [AdminController::class, 'updateExpiredItems'])->name('admin.expired-items.update');

Route::get('/penitip/penarikan-saldo', [PenitipController::class, 'showPenarikanSaldo'])->name('penitip.penarikan-saldo.form');
Route::post('/penitip/penarikan-saldo', [PenitipController::class, 'ajukanPenarikanSaldo'])->name('penitip.penarikan-saldo');

// ===== ROUTE KERANJANG DAN TRANSAKSI PEMBELI =====
Route::post('/keranjang/tambah/{id}', [PembeliController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
Route::get('/keranjang', [PembeliController::class, 'lihatKeranjang'])->name('keranjang.lihat');
Route::post('/keranjang/checkout', [PembeliController::class, 'checkoutKeranjang'])->name('keranjang.checkout');
Route::post('/keranjang/bayar', [PembeliController::class, 'bayarKeranjang'])->name('keranjang.bayar');
