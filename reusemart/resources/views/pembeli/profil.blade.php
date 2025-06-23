@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-4">
        <a href="{{ route('home') }}" class="btn btn-outline-success">
            <i class="bi bi-house-door-fill me-1"></i> Kembali ke Halaman Utama
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <span>Profil Pembeli</span>
                </div>
                <div class="card-body">

                    <h5 class="mb-3 text-success">Informasi Akun</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Nama:</strong> {{ $pembeli->nama_pembeli }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $pembeli->email_pembeli }}</li>
                        <li class="list-group-item"><strong>Username:</strong> {{ $pembeli->username_pembeli }}</li>
                        <li class="list-group-item"><strong>No Telepon:</strong> {{ $pembeli->noTelp_pembeli }}</li>
                        <li class="list-group-item"><strong>Poin:</strong> {{ $pembeli->poin }}</li>
                    </ul>

                    <h5 class="mb-3 text-success">Alamat</h5>
                    @if($pembeli->alamat)
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Alamat Lengkap:</strong> {{ $pembeli->alamat->alamat_lengkap }}</li>
                            <li class="list-group-item"><strong>Kode Pos:</strong> {{ $pembeli->alamat->kode_pos }}</li>
                        </ul>
                    @else
                        <div class="alert alert-warning">
                            Alamat belum tersedia.
                        </div>
                    @endif

                    <a href="{{ route('transaksi.riwayat') }}" class="btn btn-success mt-3">
                        <i class="bi bi-clock-history me-1"></i> Lihat Riwayat Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
