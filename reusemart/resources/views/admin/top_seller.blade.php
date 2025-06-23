@extends('layouts.app_dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen TOP SELLER</h4>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Status Saat Ini</h5>
                                    @php
                                        $currentTopSeller = \App\Models\Penitip::where('status_penitip', 'TOP SELLER')->first();
                                    @endphp
                                    
                                    @if($currentTopSeller)
                                        <p>Penitip TOP SELLER saat ini: <strong>{{ $currentTopSeller->nama_penitip }}</strong></p>
                                        <form action="{{ route('admin.top-seller.add-points') }}" method="POST" class="mt-3">
                                            @csrf
                                            <input type="hidden" name="id_penitip" value="{{ $currentTopSeller->id_penitip }}">
                                            <button type="submit" class="btn btn-success">
                                                Tambah Poin (1% dari Total Penjualan Bulan Lalu)
                                            </button>
                                        </form>
                                    @else
                                        <p>Belum ada penitip yang ditetapkan sebagai TOP SELLER</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Perhitungan TOP SELLER</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.top-seller.update') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Pilih Bulan</label>
                                            <select name="month" class="form-control" required>
                                                @foreach($months as $key => $month)
                                                    <option value="{{ $key }}">{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">
                                            Hitung & Update TOP SELLER
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($topSellers) && count($topSellers) > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Daftar Penjualan Tertinggi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Penitip</th>
                                                    <th>Jumlah Transaksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topSellers as $seller)
                                                <tr>
                                                    <td>{{ $seller->nama_penitip }}</td>
                                                    <td>{{ $seller->transaction_count }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 