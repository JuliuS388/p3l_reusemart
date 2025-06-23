<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $dataPerBulan = Transaksi::selectRaw('MONTH(tanggal_transaksi) as bulan, COUNT(*) as jumlah_transaksi, SUM(total_harga) as total_penjualan')
            ->whereYear('tanggal_transaksi', 2025)
            ->groupByRaw('MONTH(tanggal_transaksi)')
            ->get()
            ->keyBy('bulan');

        return view('laporan.penjualan', compact('dataPerBulan'));
    }

    public function exportPdf()
    {
        $dataPerBulan = Transaksi::selectRaw('MONTH(tanggal_transaksi) as bulan, COUNT(*) as jumlah_transaksi, SUM(total_harga) as total_penjualan')
            ->whereYear('tanggal_transaksi', 2025)
            ->groupByRaw('MONTH(tanggal_transaksi)')
            ->get()
            ->keyBy('bulan');

        $pdf = Pdf::loadView('laporan.penjualan_pdf', compact('dataPerBulan'));
        return $pdf->stream('laporan-penjualan-2025.pdf');
    }

    public function previewPdf()
    {
        return view('laporan.preview_pdf');
    }
}
