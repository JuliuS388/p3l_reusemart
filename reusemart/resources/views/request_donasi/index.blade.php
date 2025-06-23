@extends('layouts.app_dashboard')

@section('content')
    <h2 class="mb-4">Daftar Request Donasi</h2>

    <a href="{{ route('donasi.histori') }}" class="btn btn-primary mb-3">Lihat Histori Donasi</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Organisasi</th>
                <th>Alamat Organisasi</th>
                <th>Request Donasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $req->organisasi->nama_organisasi ?? 'N/A' }}</td>
                    <td>{{ $req->organisasi->alamat_organisasi ?? 'N/A' }}</td>
                    <td>{{ $req->request }}</td>
                    <td>
                        @if($req->status_request === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-success">Accepted</span>
                        @endif
                    </td>
                    <td>
                        @if($req->status_request === 'pending')
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalBarang-{{ $req->id_request_donasi }}">
                                Accept
                            </button>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Accepted</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach($requests as $req)
        @if($req->status_request === 'pending')
        <div class="modal fade" id="modalBarang-{{ $req->id_request_donasi }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('request-donasi.store-donasi', $req->id_request_donasi) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Barang untuk "{{ $req->request }}"</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Pilih Barang</label>
                                <select class="form-select" name="id_barang" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id_barang }}">{{ $barang->nama_barang }} - {{ $barang->kode_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Nama Penerima</label>
                                <input type="text" name="nama_penerima" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endforeach
@endsection
