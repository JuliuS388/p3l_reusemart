@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Preview Laporan Komisi Bulanan (PDF)</h2>

    <div class="mb-4">
        <iframe src="{{ route('laporan.komisi.pdf') }}" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('laporan.komisi.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('laporan.komisi.pdf') }}" class="btn btn-success" download="laporan_komisi.pdf">
            Download PDF
        </a>
    </div>
</div>
@endsection
