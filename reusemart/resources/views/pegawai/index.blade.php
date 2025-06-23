@extends('layouts.app_dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Pegawai</h2>
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary">+ Tambah Pegawai</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pegawai.index') }}" method="GET" class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Cari</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Jabatan</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawais as $pegawai)
                <tr>
                    <td>{{ $pegawai->nama_pegawai }}</td>
                    <td>{{ $pegawai->email_pegawai }}</td>
                    <td>{{ $pegawai->username_pegawai }}</td>
                    <td>{{ $pegawai->jabatan->nama_jabatan }}</td>
                    <td>{{ $pegawai->tanggal_lahir_pegawai }}</td>
                    <td>
                        <a href="{{ route('pegawai.edit', $pegawai->id_pegawai) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pegawai.destroy', $pegawai->id_pegawai) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
