@extends('layouts.app_dashboard')

@section('content')
    <h2 class="mb-4">Tambah Pegawai</h2>

    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" class="form-control @error('nama_pegawai') is-invalid @enderror" required>
            @error('nama_pegawai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email_pegawai" value="{{ old('email_pegawai') }}" class="form-control @error('email_pegawai') is-invalid @enderror" required>
            @error('email_pegawai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username_pegawai" value="{{ old('username_pegawai') }}" class="form-control @error('username_pegawai') is-invalid @enderror" required>
            @error('username_pegawai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir_pegawai" value="{{ old('tanggal_lahir_pegawai') }}" class="form-control @error('tanggal_lahir_pegawai') is-invalid @enderror" required>
            @error('tanggal_lahir_pegawai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="id_jabatan" class="form-select @error('id_jabatan') is-invalid @enderror" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id_jabatan }}" {{ old('id_jabatan') == $jabatan->id_jabatan ? 'selected' : '' }}>
                        {{ $jabatan->nama_jabatan }}
                    </option>
                @endforeach
            </select>
            @error('id_jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
@endsection
