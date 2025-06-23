<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function riwayat()
    {
        $pembeli = session('pembeli');

        $transaksis = Transaksi::with(['detailTransaksi.barang.penitip'])
            ->where('id_pembeli', $pembeli->id_pembeli)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('pembeli.riwayat_transaksi', compact('transaksis'));
    }
}
