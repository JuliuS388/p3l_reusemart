@extends('layouts.app_dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Laporan Komisi</h4>
    <a href="{{ route('laporan.komisi.preview') }}" class="btn btn-success">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success text-center">
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga Jual</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Laku</th>
                <th>Komisi ReuseMart</th>
                <th>Komisi Hunter</th>
                <th>Bonus Penitip</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $komisi)
                @php
                    $barang = $komisi->transaksi->detailTransaksi->first()->barang ?? null;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $barang->kode_produk ?? '-' }}</td>
                    <td>{{ $barang->nama_barang ?? '-' }}</td>
                    <td>Rp {{ number_format($barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($komisi->tanggal_masuk)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($komisi->tanggal_laku)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($komisi->komisi_perusahaan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($komisi->komisi_pegawai, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($komisi->bonus_penitip, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
