<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Pembeli;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi;

class PembeliController extends Controller
{
    public function profil()
    {
        $pembeli = session('pembeli');

        if (!$pembeli) {
            return redirect()->route('home');
        }

        return view('pembeli.profil', compact('pembeli'));
    }

    public function riwayatTransaksi()
    {
        $pembeli = session('pembeli');

        if (!$pembeli) {
            return redirect()->route('login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaksis = $pembeli->transaksi()->with(['detailTransaksi.barang.penitip'])->orderByDesc('tanggal_transaksi')->get();

        return view('pembeli.riwayat_transaksi', compact('transaksis'));
    }

    public function beriRating(Request $request, $id_detail_transaksi)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $detail = DetailTransaksi::findOrFail($id_detail_transaksi);
        $detail->rating = $request->rating;
        $detail->save();

        if ($detail->barang && $detail->barang->penitip) {
            $detail->barang->penitip->updateRating();
        }

        return back()->with('success', 'Rating berhasil disimpan.');
    }

    // API untuk profile pembeli
    public function apiShow($id)
    {
        $pembeli = Pembeli::with('alamat')->find($id);
        if (!$pembeli) {
            return response()->json(['message' => 'Pembeli not found'], 404);
        }
        return response()->json(['data' => $pembeli]);
    }

    // API untuk riwayat transaksi pembeli (SEMUA STATUS, sesuai user login)
    public function apiTransaksi($id = null)
    {
        if (!$id) {
            return response()->json(['message' => 'ID Pembeli tidak ditemukan'], 404);
        }

        // Debug: Log the incoming ID
        \Log::info('Fetching transactions for pembeli ID: ' . $id);

        $pembeli = Pembeli::find($id);
        if (!$pembeli) {
            \Log::error('Pembeli not found with ID: ' . $id);
            return response()->json(['message' => 'Pembeli not found'], 404);
        }

        // Get transactions with eager loading
        $transaksi = Transaksi::where('id_pembeli', $id)
            ->with(['detailTransaksi' => function($query) {
                $query->with(['barang' => function($query) {
                    $query->select('id_barang', 'nama_barang', 'foto_thumbnail', 'harga_barang');
                }]);
            }])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // Debug: Log transaction data
        \Log::info('Transactions found:', [
            'count' => $transaksi->count(),
            'data' => $transaksi->toArray()
        ]);

        return response()->json([
            'data' => $transaksi
        ]);
    }

    public function getPembeliByUserId($id_user)
    {
        try {
            $pembeli = Pembeli::with('alamat')->where('id_user', $id_user)->first();
            
            if (!$pembeli) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pembeli tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $pembeli
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createPembeli(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'nama_pembeli' => 'required|string|max:255',
            'email_pembeli' => 'required|email|max:255',
            'noTelp_pembeli' => 'required|string|max:20',
            'username_pembeli' => 'required|string|max:255|unique:pembeli',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pembeli = Pembeli::create([
                'id_user' => $request->id_user,
                'nama_pembeli' => $request->nama_pembeli,
                'email_pembeli' => $request->email_pembeli,
                'noTelp_pembeli' => $request->noTelp_pembeli,
                'username_pembeli' => $request->username_pembeli,
                'poin' => 0, // Default poin awal
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data pembeli berhasil dibuat',
                'data' => $pembeli
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePembeli(Request $request, $id_pembeli)
    {
        $validator = Validator::make($request->all(), [
            'nama_pembeli' => 'required|string|max:255',
            'email_pembeli' => 'required|email|max:255',
            'noTelp_pembeli' => 'required|string|max:20',
            'username_pembeli' => 'required|string|max:255|unique:pembeli,username_pembeli,' . $id_pembeli . ',id_pembeli',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pembeli = Pembeli::find($id_pembeli);
            
            if (!$pembeli) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pembeli tidak ditemukan'
                ], 404);
            }

            $pembeli->update([
                'nama_pembeli' => $request->nama_pembeli,
                'email_pembeli' => $request->email_pembeli,
                'noTelp_pembeli' => $request->noTelp_pembeli,
                'username_pembeli' => $request->username_pembeli,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data pembeli berhasil diperbarui',
                'data' => $pembeli
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}

