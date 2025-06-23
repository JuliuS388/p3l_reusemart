<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\BarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pembeli/{id}', [PembeliController::class, 'apiShow']);
Route::get('/pembeli/{id}/transaksi', [PembeliController::class, 'apiTransaksi']);

// Pembeli Routes
Route::get('/pembeli/user/{id_user}', [PembeliController::class, 'getPembeliByUserId']);
Route::post('/pembeli', [PembeliController::class, 'createPembeli']);
Route::put('/pembeli/{id_pembeli}', [PembeliController::class, 'updatePembeli']);

// Penitip Routes
Route::get('/penitip/user/{id_user}', [PenitipController::class, 'getPenitipByUserId']);
Route::get('/penitip/{id_penitip}/barang', [PenitipController::class, 'getPenitipBarang']);
Route::post('/penitip', [PenitipController::class, 'createPenitip']);
Route::put('/penitip/{id_penitip}', [PenitipController::class, 'updatePenitip']);

Route::get('/barang/tersedia', [BarangController::class, 'getBarangTersedia']);
