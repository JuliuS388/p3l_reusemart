<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestDonasi;
use App\Models\Organisasi;
use App\Models\Barang;
use App\Models\Donasi;
use App\Models\Penitip;

class RequestDonasiController extends Controller
{
    public function index()
    {
        $requests = RequestDonasi::with('organisasi')->get();
        $barangs = Barang::where('status_barang', 'didonasikan')->get();
        return view('request_donasi.index', compact('requests', 'barangs'));
    }

    public function storeDonasi(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'nama_penerima' => 'required|string|max:255',
        ]);

        $requestDonasi = RequestDonasi::findOrFail($id);
        $requestDonasi->status_request = 'accepted';
        $requestDonasi->save();

        Donasi::create([
            'id_barang' => $request->id_barang,
            'id_request_donasi' => $id,
            'tanggal_donasi' => now(),
            'nama_penerima' => $request->nama_penerima,
        ]);

        $barang = Barang::findOrFail($request->id_barang);
        $barang->status_barang = 'sudah didonasikan';
        $barang->save();


        if ($barang->id_penitip) {
            $penitip = Penitip::find($barang->id_penitip);
            if ($penitip) {
                $poin = floor($barang->harga_barang / 10000);
                $penitip->poin_penitip += $poin;
                $penitip->save();
            }
        }

        return redirect()->route('request-donasi.index')->with('success', 'Request berhasil diterima dan donasi dicatat.');
    }

    public function historiDonasi(Request $request)
    {
        $query = Donasi::with('barang', 'requestDonasi.organisasi');

        if ($request->has('organisasi_id') && $request->organisasi_id != '') {
            $query->whereHas('requestDonasi', function ($q) use ($request) {
                $q->where('id_organisasi', $request->organisasi_id);
            });
        }

        $donasi = $query->get();
        $organisasi = Organisasi::all();

        return view('request_donasi.histori', compact('donasi', 'organisasi'));
    }


    public function updateDonasi(Request $request, $id)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'tanggal_donasi' => 'required|date',
        ]);

        $donasi = Donasi::findOrFail($id);
        $donasi->nama_penerima = $request->nama_penerima;
        $donasi->tanggal_donasi = $request->tanggal_donasi;
        $donasi->save();

        return redirect()->route('donasi.histori')->with('success', 'Donasi berhasil diperbarui!');
    }
}
