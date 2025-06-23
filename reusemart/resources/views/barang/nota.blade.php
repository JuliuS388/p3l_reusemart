<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Penitipan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .nota-box {
            border: 1px solid #000;
            padding: 20px;
            width: 100%;
        }
        .header {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .sub-header {
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 6px 4px;
            vertical-align: top;
        }
        .right {
            text-align: right;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
<div class="nota-box">
    <div class="header">
        ReUse Mart
    </div>
    <div class="sub-header">
        Jl. Green Eco Park No. 456 Yogyakarta
    </div>

    <div class="section">
        <table>
            <tr>
                <td><strong>No Nota</strong></td>
                <td>: {{ $nomor_nota }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Penitipan</strong></td>
                <td>: {{ $tanggal_masuk }}</td>
            </tr>
            <tr>
                <td><strong>Masa Penitipan Sampai</strong></td>
                <td>: {{ $tanggal_batas }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Penitip</div>
        <div>
            T{{ $penitip->id_penitip }} / {{ $penitip->nama_penitip }}<br>
            {{ $penitip->alamat_penitip }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">Daftar Barang Dititipkan</div>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th class="right">Harga</th>
                    <th>Berat</th>
                    <th>Garansi</th>
                    <th>QC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                <tr>
                    <td>{{ $barang->nama_barang }}</td>
                    <td class="right">Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                    <td>{{ $barang->berat_barang }}</td>
                    <td>
                        @if($barang->tanggal_garansi)
                            {{ \Carbon\Carbon::parse($barang->tanggal_garansi)->isoFormat('MMMM Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($barang->pegawai)
                            P{{ $barang->pegawai->id_pegawai }} - {{ $barang->pegawai->nama_pegawai }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
