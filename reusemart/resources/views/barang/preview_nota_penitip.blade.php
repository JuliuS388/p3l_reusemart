@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Preview Nota Penitipan (PDF)</h2>

    <div class="mb-4">
        <iframe src="{{ route('barang.cetakNotaPenitip', $penitip->id_penitip) }}" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Return</a>

        <a href="{{ route('barang.cetakNotaPenitip', $penitip->id_penitip) }}" class="btn btn-success">
            Download PDF
        </a>
    </div>
</div>
@endsection
