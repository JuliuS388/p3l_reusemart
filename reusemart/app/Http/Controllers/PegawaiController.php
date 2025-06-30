<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
 use App\Models\User;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::with('jabatan');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%$search%")
                ->orWhere('email_pegawai', 'like', "%$search%")
                ->orWhere('username_pegawai', 'like', "%$search%");
            });
        }

        $pegawais = $query->get();

        return view('pegawai.index', compact('pegawais'));
    }


    public function create()
    {
        $jabatans = Jabatan::all();
        return view('pegawai.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'email_pegawai' => 'required|email',
            'username_pegawai' => 'required',
            'tanggal_lahir_pegawai' => 'required',
        ]);

        Pegawai::create($request->all());
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatans = Jabatan::all();
        return view('pegawai.edit', compact('pegawai', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'email_pegawai' => 'required|email',
            'username_pegawai' => 'required',
            'tanggal_lahir_pegawai' => 'required',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }


    public function destroy($id)
    {
        $pegawai = Pegawai::with('jabatan')->findOrFail($id);

        $jumlahPegawaiDenganJabatan = Pegawai::where('id_jabatan', $pegawai->id_jabatan)->count();

        if ($jumlahPegawaiDenganJabatan <= 1) {
            return redirect()->route('pegawai.index')->with('error', "{$pegawai->nama_pegawai} dengan role {$pegawai->jabatan->nama_jabatan} tidak boleh dihapus karena jika dihapus, nanti tidak ada user role ini di database.");
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }





}
