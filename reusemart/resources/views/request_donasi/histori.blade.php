@extends('layouts.app_dashboard')

@section('content')
    <h2 class="mb-4">Histori Donasi</h2>

    <a href="{{ route('request-donasi.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar Request</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('donasi.histori') }}" class="mb-4 row g-3 align-items-center">
        <div class="col-auto">
            <select name="organisasi_id" id="organisasi_id" class="form-select">
                <option value="">-- Semua Organisasi --</option>
                @foreach($organisasi as $org)
                    <option value="{{ $org->id_organisasi }}" {{ request('organisasi_id') == $org->id_organisasi ? 'selected' : '' }}>
                        {{ $org->nama_organisasi }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto mt-4">
            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Organisasi</th>
                <th>Request Donasi</th>
                <th>Nama Barang</th>
                <th>Tanggal Donasi</th>
                <th>Nama Penerima</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donasi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->requestDonasi->organisasi->nama_organisasi ?? 'N/A' }}</td>
                    <td>{{ $item->requestDonasi->request ?? 'N/A' }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_donasi)->format('d M Y') }}</td>
                    <td>{{ $item->nama_penerima }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id_donasi }}">Edit</button>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal-{{ $item->id_donasi }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('donasi.update', $item->id_donasi) }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Donasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Penerima</label>
                                        <input type="text" name="nama_penerima" class="form-control" value="{{ $item->nama_penerima }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Donasi</label>
                                        <input type="date" name="tanggal_donasi" class="form-control" value="{{ $item->tanggal_donasi }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data donasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
