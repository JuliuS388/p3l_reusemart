@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">Daftar Penukaran Merchandise</h2>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="status" class="form-label">Filter Status</label>
            <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                <option value="" {{ $status == null ? 'selected' : '' }}>Semua</option>
                <option value="Belum Diambil" {{ $status == 'Belum Diambil' ? 'selected' : '' }}>Belum Diambil</option>
                <option value="Sudah Diambil" {{ $status == 'Sudah Diambil' ? 'selected' : '' }}>Sudah Diambil</option>
            </select>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>ID</th>
                    <th>Nama Pembeli</th>
                    <th>Nama Merchandise</th>
                    <th>Harga (Poin)</th>
                    <th>Status</th>
                    <th>Tanggal Ambil</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td class="text-center">{{ $item->id_tukar_merch }}</td>
                    <td>{{ $item->pembeli->nama_pembeli ?? '-' }}</td>
                    <td>{{ $item->merchandise->nama_merchandise }}</td>
                    <td class="text-end">{{ number_format($item->merchandise->harga_merchandise) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $item->status_merch === 'Sudah Diambil' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $item->status_merch }}
                        </span>
                    </td>
                    <td class="text-center">{{ $item->tanggal_ambil_merch ? \Carbon\Carbon::parse($item->tanggal_ambil_merch)->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">
                        @if ($item->status_merch === 'Belum Diambil')
                        <form method="POST" action="{{ route('tukarmerch.update', $item->id_tukar_merch) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success"
                                onclick="return confirm('Yakin ingin menandai sebagai sudah diambil?')">
                                <i class="bi bi-check-circle-fill me-1"></i> Tandai Diambil
                            </button>
                        </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data penukaran merchandise.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
