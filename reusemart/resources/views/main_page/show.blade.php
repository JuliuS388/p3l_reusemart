@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            &larr; Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div id="fotoCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner rounded">
                    @if($barang->foto1_barang)
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/' . $barang->foto1_barang) }}" class="d-block w-100" alt="Foto 1">
                        </div>
                    @endif
                    @if($barang->foto2_barang)
                        <div class="carousel-item {{ !$barang->foto1_barang ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $barang->foto2_barang) }}" class="d-block w-100" alt="Foto 2">
                        </div>
                    @endif
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#fotoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#fotoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="fw-bold">{{ $barang->nama_barang }}</h4>
            <div class="text-muted mb-2">Kode Produk: {{ $barang->kode_produk }}</div>
            <div class="mb-3">
                <span class="fs-4 fw-semibold text-danger">Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</span>
            </div>

            @if($barang->deskripsi_barang)
            <div class="mt-4">
                <h6 class="fw-bold">Deskripsi Produk</h6>
                <p>{{ $barang->deskripsi_barang }}</p>
            </div>

            @if($barang->tanggal_garansi)
            <div class="mb-2">
                <span class="badge bg-info text-dark">Garansi sampai: {{ \Carbon\Carbon::parse($barang->tanggal_garansi)->translatedFormat('d F Y') }}</span>
            </div>
            @endif

            @if($barang->berat_barang)
            <div class="mb-2">
                <small class="text-muted">Berat: {{ $barang->berat_barang }}</small>
            </div>
            @endif

            @if($barang->penitip)
                <div class="mb-3">
                    <h6 class="fw-bold">Rating Penitip</h6>
                    <span class="badge bg-warning text-dark">
                        ⭐ {{ number_format($barang->penitip->rating_penitip ?? 0, 1) }} / 5
                    </span>
                </div>
            @endif



            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-success w-50">+ Keranjang</button>
                <button class="btn btn-outline-success w-50">Beli</button>
            </div>

            @endif
        </div>
    </div>
</div>
@endsection
