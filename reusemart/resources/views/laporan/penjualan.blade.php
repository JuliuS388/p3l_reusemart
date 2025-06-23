@extends('layouts.app_dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Laporan Penjualan Bulanan - {{ date('Y') }}</h4>
    <a href="{{ route('laporan.penjualan.preview') }}" class="btn btn-success">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success text-center">
            <tr>
                <th>Bulan</th>
                <th>Jumlah Transaksi</th>
                <th>Jumlah Penjualan Kotor</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 12; $i++)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</td>
                    <td class="text-center">{{ $dataPerBulan[$i]->jumlah_transaksi ?? 0 }}</td>
                    <td class="text-end">Rp {{ number_format($dataPerBulan[$i]->total_penjualan ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="card mt-4">
    <div class="card-header">
        Grafik Total Penjualan per Bulan (Rp)
    </div>
    <div class="card-body">
        <canvas id="chartPenjualan" height="100"></canvas>
    </div>
</div>

@php
    $bulanLabels = [];
    $totalPenjualan = [];

    for ($i = 1; $i <= 12; $i++) {
        $bulanLabels[] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
        $totalPenjualan[] = $dataPerBulan[$i]->total_penjualan ?? 0;
    }
@endphp
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('chartPenjualan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: {!! json_encode($totalPenjualan) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
