<?php

namespace App\Http\Controllers;

use App\Models\Komisi;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKomisiController extends Controller
{
    public function index()
    {
        $data = Komisi::with([
            'transaksi.detailTransaksi.barang',
            'pegawai',
            'penitip'
        ])->get();

        return view('laporan.komisi_index', compact('data'));
    }

    public function cetakPDF()
    {
        $data = Komisi::with([
            'transaksi.detailTransaksi.barang',
            'pegawai',
            'penitip'
        ])->get();

        $pdf = Pdf::loadView('laporan.komisi_pdf', compact('data'))
                  ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_komisi.pdf');
    }
}

