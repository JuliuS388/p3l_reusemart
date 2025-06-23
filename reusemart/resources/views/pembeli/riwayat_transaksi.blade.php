@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Riwayat Transaksi</h3>
        <a href="{{ route('pembeli.profil') }}" class="btn btn-outline-secondary">
            <i class="bi bi-person-circle me-1"></i> Kembali ke Profil
        </a>
    </div>

    @forelse($transaksis as $transaksi)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Transaksi #{{ $transaksi->id_transaksi }}</strong> 
                    <small class="text-muted">({{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }})</small>
                </div>
                <span class="badge 
                    {{ strtolower($transaksi->status_transaksi) == 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($transaksi->status_transaksi) }}
                </span>
            </div>
            <div class="card-body p-3">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Penitip</th>
                            <th class="text-center" style="width: 150px;">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($transaksi->detailTransaksi as $detail)
                        <tr>
                            <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $detail->barang->penitip->nama_penitip ?? '-' }}</td>
                            <td class="text-center align-middle">
                                @if(strtolower($transaksi->status_transaksi) == 'selesai')
                                <form action="{{ route('pembeli.beriRating', $detail->id_detail_transaksi) }}" method="POST" class="rating-form" id="rating-form-{{ $detail->id_detail_transaksi }}">
                                    @csrf
                                    <div class="star-rating d-flex flex-row-reverse justify-content-center">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" 
                                                   class="btn-check" 
                                                   name="rating" 
                                                   id="star{{ $i }}-{{ $detail->id_detail_transaksi }}" 
                                                   autocomplete="off" 
                                                   value="{{ $i }}" 
                                                   {{ ($detail->rating ?? 0) == $i ? 'checked' : '' }}>
                                            <label for="star{{ $i }}-{{ $detail->id_detail_transaksi }}" 
                                                   title="{{ $i }} stars" 
                                                   style="font-size: 1.4rem; cursor: pointer; color: #ddd;">&#9733;</label>
                                        @endfor
                                    </div>
                                </form>
                                @else
                                    @if($detail->rating)
                                        <span class="fs-5 text-warning">⭐ {{ $detail->rating }}/5</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada transaksi yang dilakukan.
        </div>
    @endforelse
</div>

<style>
.star-rating input[type="radio"] {
    display: none;
}
.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107 !important;
    transition: color 0.2s;
}
</style>

<script>
document.querySelectorAll('.star-rating input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        this.closest('form').submit();
    });
});
</script>
@endsection
