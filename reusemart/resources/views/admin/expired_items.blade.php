@extends('layouts.app_dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Barang Lewat Batas</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.expired-items.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Penitip</th>
                                        <th>Tanggal Batas Penitipan</th>
                                        <th>Status</th>
                                        <th>Keterlambatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expiredItems as $item)
                                    <tr>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->nama_penitip }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_batas_penitipan)->format('d/m/Y') }}</td>
                                        <td>{{ $item->status_barang }}</td>
                                        <td>
                                            @php
                                                $days = intval(\Carbon\Carbon::parse($item->tanggal_batas_penitipan)->diffInDays(now()));
                                            @endphp
                                            {{ $days }} hari
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada barang yang lewat batas penitipan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(count($expiredItems) > 0)
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                Update Status
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 