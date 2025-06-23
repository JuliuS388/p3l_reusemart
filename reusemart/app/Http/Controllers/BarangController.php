<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Penitip;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;


class BarangController extends Controller
{
    // public function index(Request $request)
    // {
    //     $search = $request->search;

    //     $barangQuery = Barang::with(['kategori', 'penitip', 'pegawai']);

    //     if ($search) {
    //         $barangQuery->where(function ($query) use ($search) {
    //             $query->where('nama_barang', 'like', "%$search%")
    //                 ->orWhere('kode_produk', 'like', "%$search%")
    //                 ->orWhereHas('kategori', function ($q) use ($search) {
    //                     $q->where('nama_kategori', 'like', "%$search%");
    //                 })
    //                 ->orWhereHas('penitip', function ($q) use ($search) {
    //                     $q->where('nama_penitip', 'like', "%$search%");
    //                 })
    //                 ->orWhereHas('pegawai', function ($q) use ($search) {
    //                     $q->where('nama_pegawai', 'like', "%$search%");
    //                 });
    //         });
    //     }

    //     $barang = $barangQuery->get();

    //     return view('barang.index', compact('barang'));
    // }

    public function index(Request $request)
    {
        $search = $request->search;
        $garansi = $request->garansi;

        $barangQuery = Barang::with(['kategori', 'penitip', 'pegawai']);

        if ($search) {
            $barangQuery->where(function ($query) use ($search) {
                $query->where('nama_barang', 'like', "%$search%")
                    ->orWhere('kode_produk', 'like', "%$search%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%$search%");
                    })
                    ->orWhereHas('penitip', function ($q) use ($search) {
                        $q->where('nama_penitip', 'like', "%$search%");
                    })
                    ->orWhereHas('pegawai', function ($q) use ($search) {
                        $q->where('nama_pegawai', 'like', "%$search%");
                    });
            });
        }

        if ($garansi === 'ada') {
            $barangQuery->whereNotNull('tanggal_garansi');
        } elseif ($garansi === 'tidak') {
            $barangQuery->whereNull('tanggal_garansi');
        }

        $barang = $barangQuery->get();

        return view('barang.index', compact('barang'));
    }



    public function show($id)
    {
        $barang = Barang::with(['kategori', 'penitip', 'pegawai'])->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function create()
    {
        $kategoris = KategoriBarang::all();
        $penitips = Penitip::all();
        $pegawais = Pegawai::all();

        return view('barang.create', compact('kategoris', 'penitips', 'pegawais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_produk' => 'required|string|max:255',
            'foto_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto1_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto2_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'tanggal_masuk' => 'required|date',
            'tanggal_garansi' => 'nullable|date',
            'harga_barang' => 'required|numeric',
            'status_barang' => 'required|string|max:255',
            'id_kategori' => 'required|integer|exists:kategori_barang,id_kategori',
            'id_penitip' => 'required|integer|exists:penitip,id_penitip',
            'id_pegawai' => 'required|integer|exists:pegawai,id_pegawai',
            'deskripsi_barang' => 'nullable|string',
            'berat_barang' => 'nullable|string|max:255',
        ]);

        foreach (['foto_thumbnail', 'foto1_barang', 'foto2_barang'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('barang', 'public');
            }
        }
        
        $validated['tanggal_batas_penitipan'] = \Carbon\Carbon::parse($validated['tanggal_masuk'])->addDays(30);
        Barang::create($validated);

        $barangBaru = Barang::latest()->first();
        $idPenitip = $barangBaru->id_penitip;
        return redirect()->route('barang.previewNotaPenitip', $idPenitip);



    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = KategoriBarang::all();
        $penitip = Penitip::all();
        $pegawai = Pegawai::all();

        return view('barang.edit', compact('barang', 'kategori', 'penitip', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_produk' => 'required|string|max:255',
            'foto_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto1_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto2_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'tanggal_masuk' => 'required|date',
            'tanggal_garansi' => 'nullable|date',
            'harga_barang' => 'required|numeric',
            'status_barang' => 'required|string|max:255',
            'id_kategori' => 'required|integer|exists:kategori_barang,id_kategori',
            'id_penitip' => 'required|integer|exists:penitip,id_penitip',
            'id_pegawai' => 'required|integer|exists:pegawai,id_pegawai',
            'deskripsi_barang' => 'nullable|string',
            'berat_barang' => 'nullable|string|max:255',
        ]);

        foreach (['foto_thumbnail', 'foto1_barang', 'foto2_barang'] as $field) {
            if ($request->hasFile($field)) {
                if ($barang->$field) {
                    Storage::disk('public')->delete($barang->$field);
                }
                $validated[$field] = $request->file($field)->store('barang', 'public');
            }
        }

        // Update tanggal_batas_penitipan jika tanggal_masuk berubah
        if ($request->tanggal_masuk != $barang->tanggal_masuk) {
            $validated['tanggal_batas_penitipan'] = \Carbon\Carbon::parse($request->tanggal_masuk)->addDays(30);
        }

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        
        foreach (['foto_thumbnail', 'foto1_barang', 'foto2_barang'] as $field) {
            if ($barang->$field) {
                Storage::disk('public')->delete($barang->$field);
            }
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }

    public function viewPdfNota($id)
    {
        $barang = Barang::with(['penitip', 'pegawai'])->findOrFail($id);
        $id_barang = $barang->id_barang ?? $barang->id;
        $nomorNota = $this->generateNotaNumber($id_barang);

        $pdf = Pdf::loadView('barang.nota', [
            'barang' => $barang,
            'nomor_nota' => $nomorNota,
            'tanggal_masuk' => Carbon::parse($barang->tanggal_masuk)->format('d/m/Y H:i:s'),
            'tanggal_batas' => Carbon::parse($barang->tanggal_batas_penitipan)->format('d/m/Y'),
            'penitip' => $barang->penitip,
            'pegawai' => $barang->pegawai,
        ]);

        return $pdf->stream('preview-nota-barang.pdf');
    }


    private function generateNotaNumber($id_barang)
    {
        $tanggal = Carbon::now();
        $tahun = $tanggal->format('Y'); // 4 digit tahun, misal 2024
        $bulan = $tanggal->format('m'); // 2 digit bulan, misal 06
        return "$tahun.$bulan." . str_pad($id_barang, 3, '0', STR_PAD_LEFT);
    }


public function previewNotaPenitip($id)
{
    $penitip = Penitip::findOrFail($id);
    $barangPertama = Barang::where('id_penitip', $id)->firstOrFail();

    return view('barang.preview_nota_penitip', [
        'penitip' => $penitip,
        'barang' => $barangPertama
    ]);
}

public function cetakNotaPenitip($id)
{
    $penitip = Penitip::findOrFail($id);
    $barangs = Barang::with('pegawai')
        ->where('id_penitip', $penitip->id_penitip)
        ->get();

    if ($barangs->isEmpty()) {
        return redirect()->route('barang.index')->with('error', 'Penitip ini tidak memiliki barang.');
    }

    $tanggalMasuk = Carbon::parse($barangs->first()->tanggal_masuk)->format('d/m/Y H:i:s');
    $tanggalBatas = Carbon::parse($barangs->first()->tanggal_batas_penitipan)->format('d/m/Y');

    $nomorNota = $this->generateNotaNumber($barangs->first()->id_barang);

    $pdf = Pdf::loadView('barang.nota', [
        'barangs' => $barangs,
        'barang' => $barangs->first(),
        'nomor_nota' => $nomorNota,
        'tanggal_masuk' => $tanggalMasuk,
        'tanggal_batas' => $tanggalBatas,
        'penitip' => $penitip,
    ]);

    return $pdf->stream('nota_penitip_'.$penitip->id_penitip.'.pdf');
}

public function getBarangTersedia()
{
    try {
        $barangs = Barang::where('status_barang', 'Tersedia')
            ->with(['kategori', 'penitip'])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $barangs
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

public function updateToDonation($id)
{
    $barang = Barang::findOrFail($id);
    
    // Check if item is expired (7 days after batas penitipan)
    if (!$barang->tanggal_batas_penitipan || 
        !Carbon::parse($barang->tanggal_batas_penitipan)->addDays(7)->isPast()) {
        return redirect()->route('barang.index')
            ->with('error', 'Barang belum melewati batas masa penitipan + 7 hari');
    }

    $barang->update([
        'status_barang' => 'Didonasikan'
    ]);

    return redirect()->route('barang.index')
        ->with('success', 'Status barang berhasil diubah menjadi didonasikan');
}

public function expired()
{
    $expiredItems = Barang::with(['penitip'])
        ->whereNotNull('tanggal_batas_penitipan')
        ->where(function ($query) {
            $query->whereRaw('DATE_ADD(tanggal_batas_penitipan, INTERVAL 7 DAY) <= CURDATE()')
                ->where('status_barang', '!=', 'Didonasikan');
        })
        ->get();

    return view('barang.expired', compact('expiredItems'));
}

public function updateAllToDonation()
{
    $expiredItems = Barang::whereNotNull('tanggal_batas_penitipan')
        ->where(function ($query) {
            $query->whereRaw('DATE_ADD(tanggal_batas_penitipan, INTERVAL 7 DAY) <= CURDATE()')
                ->where('status_barang', '!=', 'Didonasikan');
        })
        ->get();

    if ($expiredItems->isEmpty()) {
        return redirect()->route('barang.expired')
            ->with('error', 'Tidak ada barang yang perlu diubah statusnya');
    }

    foreach ($expiredItems as $item) {
        $item->update(['status_barang' => 'Didonasikan']);
    }

    return redirect()->route('barang.expired')
        ->with('success', 'Status ' . $expiredItems->count() . ' barang berhasil diubah menjadi didonasikan');
}




}

