<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;

class LaporanStokGudangController extends Controller
{
   public function stokGudang()
    {
        $barangTersedia = Barang::with(['penitip', 'hunter'])
            ->where('status_barang', 'tersedia')
            ->get();

        return view('laporan.stok_gudang', compact('barangTersedia'));
    }

    public function stokGudangPdf()
    {
        $barangTersedia = Barang::with(['penitip', 'hunter'])
            ->where('status_barang', 'tersedia')
            ->get();

        $pdf = Pdf::loadView('laporan.stok_gudang_pdf', compact('barangTersedia'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan_stok_gudang.pdf');
    }

    public function previewStokGudang()
    {
        return view('laporan.preview_stok_gudang');
    }
}
