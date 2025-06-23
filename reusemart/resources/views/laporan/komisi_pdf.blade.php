<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Komisi Bulanan</title>
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
        <h4>LAPORAN KOMISI BULANAN</h4>

        <div class="info">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 50%;">Bulan : {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F') }}</td>
                </tr>
                <td style="width: 50%;">Tahun : {{ \Carbon\Carbon::now()->year }}</td>
                <tr>
                    <td colspan="2">Tanggal Cetak : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
                </tr>
            </table>
        </div>

        {{-- TABEL KOMISI --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Jual</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Laku</th>
                    <th>Komisi Hunter</th>
                    <th>Komisi ReUse Mart</th>
                    <th>Bonus Penitip</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_harga = $total_kh = $total_kr = $total_bp = 0;
                @endphp
                @foreach($data as $komisi)
                    @php
                        $barang = $komisi->transaksi->detailTransaksi->first()->barang ?? null;
                        $harga = $barang->harga_barang ?? 0;
                        $total_harga += $harga;
                        $total_kh += $komisi->komisi_pegawai;
                        $total_kr += $komisi->komisi_perusahaan;
                        $total_bp += $komisi->bonus_penitip;
                    @endphp
                    <tr>
                        <td>{{ $barang->kode_produk ?? '-' }}</td>
                        <td>{{ $barang->nama_barang ?? '-' }}</td>
                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($komisi->tanggal_masuk)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($komisi->tanggal_laku)->format('d/m/Y') }}</td>
                        <td>Rp {{ number_format($komisi->komisi_pegawai, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($komisi->komisi_perusahaan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($komisi->bonus_penitip, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th>Rp {{ number_format($total_harga, 0, ',', '.') }}</th>
                    <th colspan="2"></th>
                    <th>Rp {{ number_format($total_kh, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($total_kr, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($total_bp, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
