<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .kop {
            border: 1px solid #000;
            padding: 10px;
            width: 100%;
        }
        .kop h3, .kop h4, .kop p {
            margin: 0;
            padding: 0;
        }
        .kop h3 {
            font-weight: bold;
        }
        .kop h4 {
            margin-top: 5px;
            text-decoration: underline;
        }
        .kop .info {
            margin-top: 8px;
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="kop">
        <h3>ReUse Mart</h3>
        <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
        <h4>LAPORAN PENJUALAN BULANAN</h4>
        <div class="info">
            <table style="width:100%; border: none;">
                <tr>
                    <td style="width: 50%;">Tahun : {{ \Carbon\Carbon::now()->year }}</td>
                </tr>
                <td style="width: 50%;">Tanggal cetak: {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</td>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah Barang Terjual</th>
                        <th>Jumlah Penjualan Kotor</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTransaksi = 0;
                        $totalPenjualan = 0;
                    @endphp

                    @for ($i = 1; $i <= 12; $i++)
                        @php
                            $bulan = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
                            $jumlahTransaksi = $dataPerBulan[$i]->jumlah_transaksi ?? null;
                            $penjualan = $dataPerBulan[$i]->total_penjualan ?? null;

                            if ($jumlahTransaksi !== null) $totalTransaksi += $jumlahTransaksi;
                            if ($penjualan !== null) $totalPenjualan += $penjualan;
                        @endphp
                        <tr>
                            <td>{{ $bulan }}</td>
                            <td>{{ $jumlahTransaksi !== null ? $jumlahTransaksi : '....' }}</td>
                            <td>{{ $penjualan !== null ? number_format($penjualan, 0, ',', '.') : '....' }}</td>
                        </tr>
                    @endfor

                    {{-- TOTAL ROW --}}
                    <tr>
                        <th class="text-right" colspan="1">Total</th>
                        <th class="text-center">{{ $totalTransaksi }}</th>
                        <th class="text-center">{{ number_format($totalPenjualan, 0, ',', '.') }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABLE --}}
    

</body>
</html>
