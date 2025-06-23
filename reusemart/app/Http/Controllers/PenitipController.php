<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PenitipController extends Controller
{
    public function getPenitipByUserId($id_user)
    {
        try {
            $penitip = Penitip::where('id_user', $id_user)->first();
            
            if (!$penitip) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data penitip tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $penitip
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createPenitip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'nama_penitip' => 'required|string|max:255',
            'email_penitip' => 'required|email|max:255',
            'noTelp_penitip' => 'required|string|max:20',
            'username_penitip' => 'required|string|max:255|unique:penitip',
            'alamat_penitip' => 'required|string|max:255',
            'status_penitip' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $penitip = Penitip::create([
                'id_user' => $request->id_user,
                'nama_penitip' => $request->nama_penitip,
                'email_penitip' => $request->email_penitip,
                'noTelp_penitip' => $request->noTelp_penitip,
                'username_penitip' => $request->username_penitip,
                'alamat_penitip' => $request->alamat_penitip,
                'saldo_penitip' => 0,
                'poin_penitip' => 0,
                'rating_penitip' => null,
                'status_penitip' => $request->status_penitip,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data penitip berhasil dibuat',
                'data' => $penitip
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePenitip(Request $request, $id_penitip)
    {
        $validator = Validator::make($request->all(), [
            'nama_penitip' => 'required|string|max:255',
            'email_penitip' => 'required|email|max:255',
            'noTelp_penitip' => 'required|string|max:20',
            'username_penitip' => 'required|string|max:255|unique:penitip,username_penitip,' . $id_penitip . ',id_penitip',
            'alamat_penitip' => 'required|string|max:255',
            'status_penitip' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $penitip = Penitip::find($id_penitip);
            
            if (!$penitip) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data penitip tidak ditemukan'
                ], 404);
            }

            $penitip->update([
                'nama_penitip' => $request->nama_penitip,
                'email_penitip' => $request->email_penitip,
                'noTelp_penitip' => $request->noTelp_penitip,
                'username_penitip' => $request->username_penitip,
                'alamat_penitip' => $request->alamat_penitip,
                'status_penitip' => $request->status_penitip,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data penitip berhasil diperbarui',
                'data' => $penitip
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPenitipBarang($id_penitip)
    {
        try {
            $penitip = Penitip::find($id_penitip);
            
            if (!$penitip) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data penitip tidak ditemukan'
                ], 404);
            }

            $barang = $penitip->barang()
                ->with(['kategori', 'pegawai'])
                ->orderBy('tanggal_masuk', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $barang
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showPenarikanSaldo()
    {
        $user = Auth()->user();
        if (!$user || $user->role !== 'penitip') {
            return redirect()->route('login.form')->with('error', 'Silakan login sebagai penitip.');
        }
        $penitip = Penitip::where('id_user', $user->id_user)->first();
        if (!$penitip) {
            return redirect()->route('login.form')->with('error', 'Data penitip tidak ditemukan.');
        }
        session(['penitip' => $penitip]);
        return view('penitip.pengajuan_penarikan_saldo', compact('penitip'));
    }

    public function ajukanPenarikanSaldo(Request $request)
    {
        $user = Auth()->user();
        if (!$user || $user->role !== 'penitip') {
            return redirect()->route('login.form')->with('error', 'Silakan login sebagai penitip.');
        }
        $penitip = Penitip::where('id_user', $user->id_user)->first();
        if (!$penitip) {
            return redirect()->route('login.form')->with('error', 'Data penitip tidak ditemukan.');
        }
        $request->validate([
            'nominal_tarik' => 'required|numeric|min:1|max:' . $penitip->saldo_penitip,
        ]);
        $nominal = $request->nominal_tarik;
        $fee = 0.05 * $nominal;
        $total_diproses = $nominal - $fee;
        if ($penitip->saldo_penitip < $nominal) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }
        $penitip->saldo_penitip -= $nominal;
        $penitip->nominal_tarik += $nominal - $fee; 
        $penitip->save();
        session(['penitip' => $penitip]); 
        return back()->with('success', 'Penarikan saldo berhasil diajukan. Saldo yang diterima: Rp ' . number_format($total_diproses, 0, ',', '.'));
    }
} 