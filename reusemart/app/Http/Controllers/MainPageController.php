<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class MainPageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $barangs = Barang::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                ->orWhere('kode_produk', 'like', '%' . $search . '%');
            });
        })
        ->where('status_barang', 'Tersedia')
        ->latest()
        ->take(12)
        ->get();

        $pembeli = session('pembeli'); 

        return view('main_page.index', compact('barangs', 'pembeli'));
    }



    public function showPublic($id)
    {
        $barang = Barang::with('penitip')->findOrFail($id);

        if ($barang->penitip) {
            $barang->penitip->updateRating();
            $barang->load('penitip');
        }

        return view('main_page.show', compact('barang'));
    }

}