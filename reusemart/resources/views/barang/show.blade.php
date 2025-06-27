@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Barang</h4>
        </div>
        <div class="card-body row">
            <div class="col-md-5">
                @if($barang->foto_thumbnail)
                    <img src="{{ asset('storage/' . $barang->foto_thumbnail) }}" class="img-fluid mb-3" alt="Thumbnail">
                @endif

                <div class="d-flex gap-2">
                    @if($barang->foto1_barang)
                        <img src="{{ asset('storage/' . $barang->foto1_barang) }}" class="img-thumbnail" style="width: 100px;" alt="Foto 1">
                    @endif
                    @if($barang->foto2_barang)
                        <img src="{{ asset('storage/' . $barang->foto2_barang) }}" class="img-thumbnail" style="width: 100px;" alt="Foto 2">
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <table class="table table-borderless">
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->nama_barang }}</td>
                    </tr>
                    <tr>
                        <th>Kode Produk</th>
                        <td>{{ $barang->kode_produk }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $barang->status_barang }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Batas Penitipan</th>
                        <td>
                            @if(filled($barang->tanggal_batas_penitipan))
                                {{ \Carbon\Carbon::parse($barang->tanggal_batas_penitipan)->format('d-m-Y') }}
                            @else
                                Belum ditentukan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Garansi</th>
                        <td>
                            @if(filled($barang->tanggal_garansi))
                                {{ \Carbon\Carbon::parse($barang->tanggal_garansi)->format('d-m-Y') }}
                            @else
                                Tidak ada garansi
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>{{ $barang->berat_barang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Penitip</th>
                        <td>{{ $barang->penitip->nama_penitip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $barang->deskripsi_barang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pengecek (QC)</th>
                        <td>{{ $barang->pegawai->nama_pegawai ?? '-' }}</td>
                    </tr>

                </table>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                <form action="{{ route('keranjang.tambah', $barang->id_barang) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
