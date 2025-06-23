@extends('layouts.app_dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Laporan Stok Gudang</h4>
    <a href="{{ route('laporan.stokgudang.preview') }}" class="btn btn-success">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success text-center">
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>ID Penitip</th>
                <th>Nama Penitip</th>
                <th>Tanggal Masuk</th>
                <th>Perpanjangan</th>
                <th>ID Hunter</th>
                <th>Nama Hunter</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangTersedia as $barang)
            <tr>
                <td>{{ $barang->kode_produk }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ 'T' . $barang->penitip->id_penitip }}</td>
                <td>{{ $barang->penitip->nama_penitip }}</td>
                <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') }}</td>
                <td>{{ $barang->perpanjangan ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $barang->id_hunter ? 'P' . $barang->id_hunter : '-' }}</td>
                <td>{{ $barang->hunter->nama_pegawai ?? '-' }}</td>
                <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
