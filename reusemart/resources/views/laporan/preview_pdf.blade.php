@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Preview Laporan Penjualan Bulanan (PDF)</h2>

    <div class="mb-4">
        <iframe src="{{ route('laporan.penjualan.pdf') }}" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('laporan.penjualan.index') }}" class="btn btn-secondary">Kembali</a>

        <a href="{{ route('laporan.penjualan.pdf') }}" class="btn btn-success" download="laporan-penjualan-2025.pdf">
            Download PDF
        </a>
    </div>
</div>
@endsection
