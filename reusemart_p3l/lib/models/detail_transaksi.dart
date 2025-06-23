import 'barang.dart';

class DetailTransaksi {
  final int idDetailTransaksi;
  final int idTransaksi;
  final int idBarang;
  final int jumlahBarang;
  final double subTotalHarga;
  final int? rating;
  final Barang? barang;

  DetailTransaksi({
    required this.idDetailTransaksi,
    required this.idTransaksi,
    required this.idBarang,
    required this.jumlahBarang,
    required this.subTotalHarga,
    this.rating,
    this.barang,
  });

  factory DetailTransaksi.fromJson(Map<String, dynamic> json) {
    try {
      print('Parsing DetailTransaksi: $json');
      
      // Parse subTotal_harga
      double subTotalHarga;
      if (json['subTotal_harga'] is int) {
        subTotalHarga = (json['subTotal_harga'] as int).toDouble();
      } else if (json['subTotal_harga'] is double) {
        subTotalHarga = json['subTotal_harga'];
      } else {
        subTotalHarga = 0.0;
      }

      return DetailTransaksi(
        idDetailTransaksi: json['id_detail_transaksi'] ?? 0,
        idTransaksi: json['id_transaksi'] ?? 0,
        idBarang: json['id_barang'] ?? 0,
        jumlahBarang: json['jumlah_barang'] ?? 1,
        subTotalHarga: subTotalHarga,
        rating: json['rating'],
        barang: json['barang'] != null ? Barang.fromJson(json['barang']) : null,
      );
    } catch (e) {
      print('Error in DetailTransaksi.fromJson: $e');
      print('JSON data: $json');
      rethrow;
    }
  }
} 