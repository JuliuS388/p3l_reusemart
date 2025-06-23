@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Barang</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formUpdateBarang" action="{{ route('barang.update', $barang->id_barang) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" value="{{ old('kode_produk', $barang->kode_produk) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi_barang" class="form-control" value="{{ old('deskripsi_barang', $barang->deskripsi_barang) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Berat</label>
                <input type="text" name="berat_barang" class="form-control" value="{{ old('berat_barang', $barang->berat_barang) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $barang->tanggal_masuk) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Garansi</label>
                <input type="date" name="tanggal_garansi" class="form-control" value="{{ old('tanggal_garansi', $barang->tanggal_garansi) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Harga</label>
                <input type="number" step="0.01" name="harga_barang" class="form-control" value="{{ old('harga_barang', $barang->harga_barang) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <input type="text" name="status_barang" class="form-control" value="{{ old('status_barang', $barang->status_barang) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Kategori Barang</label>
                <select name="id_kategori" class="form-select" required>
                    <option value="" disabled {{ old('id_kategori', $barang->id_kategori) ? '' : 'selected' }}>-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}" 
                            {{ old('id_kategori', $barang->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Penitip</label>
                <select name="id_penitip" class="form-select" required>
                    <option value="" disabled {{ old('id_penitip', $barang->id_penitip) ? '' : 'selected' }}>-- Pilih Penitip --</option>
                    @foreach($penitip as $p)
                        <option value="{{ $p->id_penitip }}" 
                            {{ old('id_penitip', $barang->id_penitip) == $p->id_penitip ? 'selected' : '' }}>
                            {{ $p->nama_penitip }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Pegawai QC</label>
                <select name="id_pegawai" class="form-select">
                    <option value="" disabled {{ old('id_pegawai', $barang->id_pegawai) ? '' : 'selected' }}>-- Pilih Pegawai QC --</option>
                    @foreach($pegawai as $pgw)
                        <option value="{{ $pgw->id_pegawai }}"
                            {{ old('id_pegawai', $barang->id_pegawai) == $pgw->id_pegawai ? 'selected' : '' }}>
                            {{ $pgw->nama_pegawai }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Foto Thumbnail</label>
                <input type="file" name="foto_thumbnail" class="form-control">
                @if($barang->foto_thumbnail)
                    <img src="{{ asset('storage/' . $barang->foto_thumbnail) }}" width="100" class="mt-2">
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Foto 1</label>
                <input type="file" name="foto1_barang" class="form-control">
                @if($barang->foto1_barang)
                    <img src="{{ asset('storage/' . $barang->foto1_barang) }}" width="100" class="mt-2">
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Foto 2</label>
                <input type="file" name="foto2_barang" class="form-control">
                @if($barang->foto2_barang)
                    <img src="{{ asset('storage/' . $barang->foto2_barang) }}" width="100" class="mt-2">
                @endif
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('formUpdateBarang').addEventListener('submit', function(e) {
        let confirmed = confirm('Apakah Anda yakin ingin mengupdate data barang ini?');
        if (!confirmed) {
            e.preventDefault();
        }
    });
</script>
@endsection
