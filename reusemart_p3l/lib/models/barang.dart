import 'penitip.dart';

class Barang {
  final int idBarang;
  final String namaBarang;
  final String kodeProduk;
  final String? fotoThumbnail;
  final String? foto1Barang;
  final String? foto2Barang;
  final String tanggalMasuk;
  final String? tanggalGaransi;
  final double hargaBarang;
  final String statusBarang;
  final int idKategori;
  final int idPenitip;
  final int idPegawai;
  final String? deskripsiBarang;
  final String? beratBarang;
  final String? tanggalBatasPenitipan;
  final bool? perpanjangan;
  final Penitip? penitip;

  Barang({
    required this.idBarang,
    required this.namaBarang,
    required this.kodeProduk,
    this.fotoThumbnail,
    this.foto1Barang,
    this.foto2Barang,
    required this.tanggalMasuk,
    this.tanggalGaransi,
    required this.hargaBarang,
    required this.statusBarang,
    required this.idKategori,
    required this.idPenitip,
    required this.idPegawai,
    this.deskripsiBarang,
    this.beratBarang,
    this.tanggalBatasPenitipan,
    this.perpanjangan,
    this.penitip,
  });

  factory Barang.fromJson(Map<String, dynamic> json) {
    // Helper function untuk konversi ke int
    int toInt(dynamic value) {
      if (value == null) return 0;
      if (value is int) return value;
      if (value is String) return int.tryParse(value) ?? 0;
      return 0;
    }

    // Helper function untuk konversi ke double
    double toDouble(dynamic value) {
      if (value == null) return 0.0;
      if (value is double) return value;
      if (value is int) return value.toDouble();
      if (value is String) return double.tryParse(value) ?? 0.0;
      return 0.0;
    }

    // Helper function untuk konversi ke String
    String? toString(dynamic value) {
      if (value == null) return null;
      return value.toString();
    }

    // Helper function untuk konversi ke bool
    bool? toBool(dynamic value) {
      if (value == null) return null;
      if (value is bool) return value;
      if (value is int) return value == 1;
      if (value is String) return value.toLowerCase() == 'true' || value == '1';
      return null;
    }

    return Barang(
      idBarang: toInt(json['id_barang']),
      namaBarang: toString(json['nama_barang']) ?? '',
      kodeProduk: toString(json['kode_produk']) ?? '',
      fotoThumbnail: toString(json['foto_thumbnail']),
      foto1Barang: toString(json['foto1_barang']),
      foto2Barang: toString(json['foto2_barang']),
      tanggalMasuk: toString(json['tanggal_masuk']) ?? '',
      tanggalGaransi: toString(json['tanggal_garansi']),
      hargaBarang: toDouble(json['harga_barang']),
      statusBarang: toString(json['status_barang']) ?? '',
      idKategori: toInt(json['id_kategori']),
      idPenitip: toInt(json['id_penitip']),
      idPegawai: toInt(json['id_pegawai']),
      deskripsiBarang: toString(json['deskripsi_barang']),
      beratBarang: toString(json['berat_barang']),
      tanggalBatasPenitipan: toString(json['tanggal_batas_penitipan']),
      perpanjangan: toBool(json['perpanjangan']),
      penitip: json['penitip'] != null ? Penitip.fromJson(json['penitip']) : null,
    );
  }
}