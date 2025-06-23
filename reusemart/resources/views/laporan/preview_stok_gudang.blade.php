@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Preview Laporan Stok Gudang (PDF)</h2>

    <div class="mb-4">
        <iframe src="{{ route('laporan.stokgudang.pdf') }}" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('laporan.stokgudang') }}" class="btn btn-secondary">Kembali</a>

        <a href="{{ route('laporan.stokgudang.pdf') }}" class="btn btn-success" download="laporan_stok_gudang.pdf">
            Download PDF
        </a>
    </div>
</div>
@endsection
