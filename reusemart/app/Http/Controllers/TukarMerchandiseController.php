<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tukarmerchandise;
use App\Models\Merchandise;
use Carbon\Carbon;

class TukarMerchandiseController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Tukarmerchandise::with(['merchandise', 'pembeli']);

        if ($status) {
            $query->where('status_merch', $status);
        }

        $data = $query->get();

        return view('tukarmerch.index', compact('data', 'status'));
    }



    public function update(Request $request, $id)
    {
        $item = Tukarmerchandise::findOrFail($id);
        $item->tanggal_ambil_merch = Carbon::now();
        $item->status_merch = 'Sudah Diambil';
        $item->save();

        return redirect()->route('tukarmerch.index')->with('success', 'Status merchandise berhasil diperbarui.');
    }
}
