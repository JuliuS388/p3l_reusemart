@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Barang</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" value="{{ old('kode_produk') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi_barang" class="form-control" value="{{ old('deskripsi_barang') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Berat</label>
                <input type="text" name="berat_barang" class="form-control" value="{{ old('berat_barang') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Garansi</label>
                <input type="date" name="tanggal_garansi" class="form-control" value="{{ old('tanggal_garansi') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Harga</label>
                <input type="number" step="0.01" name="harga_barang" class="form-control" value="{{ old('harga_barang') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <input type="text" name="status_barang" class="form-control" value="{{ old('status_barang') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Kategori Barang</label>
                <select name="id_kategori" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}" 
                            {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Penitip</label>
                <select name="id_penitip" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Penitip --</option>
                    @foreach($penitips as $penitip)
                        <option value="{{ $penitip->id_penitip }}" 
                            {{ old('id_penitip') == $penitip->id_penitip ? 'selected' : '' }}>
                            {{ $penitip->nama_penitip }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Pegawai QC</label>
                <select name="id_pegawai" class="form-select" required>
                    <option value="" disabled {{ old('id_pegawai') ? '' : 'selected' }}>-- Pilih Pegawai QC --</option>
                    @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id_pegawai }}" 
                            {{ old('id_pegawai') == $pegawai->id_pegawai ? 'selected' : '' }}>
                            {{ $pegawai->nama_pegawai }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-6">
                <label class="form-label">Foto Thumbnail</label>
                <input type="file" name="foto_thumbnail" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Foto 1</label>
                <input type="file" name="foto1_barang" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Foto 2</label>
                <input type="file" name="foto2_barang" class="form-control">
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
