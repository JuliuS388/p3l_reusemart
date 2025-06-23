<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Gudang</title>
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

    <div class="kop">
        <h3>ReUse Mart</h3>
        <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
        <h4>LAPORAN STOK GUDANG</h4>
        <div class="info">
            <table style="width:100%; border: none;">
                <tr>
                    <td style="width: 50%;">Tanggal cetak: {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</td>
                </tr>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>ID Penitip</th>
                        <th>Nama Penitip</th>
                        <th>Tanggal Masuk</th>
                        <th>Perpanjangan</th>
                        <th>ID Hunter</th>
                        <th>Nama Hunter</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangTersedia as $barang)
                    <tr>
                        <td>{{ $barang->kode_produk }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ 'T' . $barang->penitip->id_penitip }}</td>
                        <td>{{ $barang->penitip->nama_penitip }}</td>
                        <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') }}</td>
                        <td>{{ $barang->perpanjangan ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $barang->id_hunter ? 'P' . $barang->id_hunter : '-' }}</td>
                        <td>{{ $barang->hunter ? $barang->hunter->nama_pegawai : '-' }}</td>
                        <td>{{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
