<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function topSellerManagement()
    {
        $currentTopSeller = Penitip::where('status_penitip', 'TOP SELLER')
            ->first();

        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $months[$date->format('Y-m')] = $date->format('F Y');
        }

        return view('admin.top_seller', compact('currentTopSeller', 'months'));
    }

    public function updateTopSeller(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m'
        ]);

        try {
            DB::beginTransaction();
            Penitip::where('status_penitip', 'TOP SELLER')
                ->update(['status_penitip' => null]);


            $date = Carbon::createFromFormat('Y-m', $request->month);
            $startDate = $date->startOfMonth()->format('Y-m-d');
            $endDate = $date->endOfMonth()->format('Y-m-d');


            $completedTransactions = Transaksi::where('status_transaksi', 'Selesai')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->get();


            $penitipSales = [];
            foreach ($completedTransactions as $transaction) {

                $transactionItems = DetailTransaksi::where('id_transaksi', $transaction->id_transaksi)
                    ->join('barang', 'detail_transaksi.id_barang', '=', 'barang.id_barang')
                    ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
                    ->select('penitip.id_penitip', 'penitip.nama_penitip', 'detail_transaksi.subTotal_harga')
                    ->get();

                foreach ($transactionItems as $item) {
                    if (!isset($penitipSales[$item->id_penitip])) {
                        $penitipSales[$item->id_penitip] = [
                            'id_penitip' => $item->id_penitip,
                            'nama_penitip' => $item->nama_penitip,
                            'total_sales' => 0,
                            'transaction_count' => 0
                        ];
                    }
                    $penitipSales[$item->id_penitip]['total_sales'] += $item->subTotal_harga;
                }
 
                foreach ($transactionItems as $item) {
                    $penitipSales[$item->id_penitip]['transaction_count']++;
                }
            }

            uasort($penitipSales, function($a, $b) {
                return $b['total_sales'] <=> $a['total_sales'];
            });

            $topPenitip = reset($penitipSales);

            if ($topPenitip) {

                Penitip::where('id_penitip', $topPenitip['id_penitip'])
                    ->update(['status_penitip' => 'TOP SELLER']);

  
                $topSellers = array_slice($penitipSales, 0, 10);

                DB::commit();

                return redirect()->route('admin.top-seller')
                    ->with('success', 'TOP SELLER berhasil diperbarui')
                    ->with('topSellers', $topSellers);
            } else {
                DB::rollBack();
                return redirect()->route('admin.top-seller')
                    ->with('error', 'Tidak ada data penjualan untuk bulan yang dipilih');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in updateTopSeller: ' . $e->getMessage());
            return redirect()->route('admin.top-seller')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function addPointsToTopSeller(Request $request)
    {
        try {
            $penitip = Penitip::findOrFail($request->id_penitip);
            

            $lastMonth = date('m', strtotime('-1 month'));
            $year = date('Y');

            if ($lastMonth == 12) {
                $year = date('Y', strtotime('-1 year'));
            }
            
            $totalSales = DB::table('transaksi')
                ->join('detail_transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
                ->join('barang', 'detail_transaksi.id_barang', '=', 'barang.id_barang')
                ->where('barang.id_penitip', $penitip->id_penitip)
                ->where('transaksi.status_transaksi', 'SELESAI')
                ->whereMonth('transaksi.tanggal_transaksi', $lastMonth)
                ->whereYear('transaksi.tanggal_transaksi', $year)
                ->sum('detail_transaksi.subTotal_harga');
            

            $points = floor($totalSales * 0.01);
            
    
            $penitip->poin_penitip += $points;
            $penitip->save();
            
            return redirect()->route('admin.top-seller')
                ->with('success', 'Poin berhasil ditambahkan: ' . number_format($points, 0, ',', '.') . ' poin (berdasarkan penjualan ' . date('F Y', strtotime("$year-$lastMonth-01")) . ')');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.top-seller')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function expiredItems()
    {
        $expiredItems = DB::table('barang')
            ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->where('barang.status_barang', '!=', 'didonasikan')
            ->whereRaw('DATEDIFF(CURRENT_DATE, barang.tanggal_batas_penitipan) > 7')
            ->select(
                'barang.id_barang',
                'barang.nama_barang',
                'barang.tanggal_batas_penitipan',
                'barang.status_barang',
                'penitip.nama_penitip'
            )
            ->get();

        return view('admin.expired_items', compact('expiredItems'));
    }

    public function updateExpiredItems(Request $request)
    {
        try {
            $updated = DB::table('barang')
                ->where('status_barang', '!=', 'didonasikan')
                ->whereRaw('DATEDIFF(CURRENT_DATE, tanggal_batas_penitipan) > 7')
                ->update([
                    'status_barang' => 'didonasikan',
                    'updated_at' => now()
                ]);

            if ($updated > 0) {
                return redirect()->route('admin.expired-items')
                    ->with('success', $updated . ' barang berhasil diupdate menjadi didonasikan');
            } else {
                return redirect()->route('admin.expired-items')
                    ->with('error', 'Tidak ada barang yang perlu diupdate');
            }
                
        } catch (\Exception $e) {
            return redirect()->route('admin.expired-items')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 