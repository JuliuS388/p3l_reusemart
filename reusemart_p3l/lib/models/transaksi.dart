import 'barang.dart';
import 'pembeli.dart';
import 'package:intl/intl.dart';
import 'detail_transaksi.dart';
import 'package:flutter/material.dart';

class DetailTransaksi {
  final int idDetailTransaksi;
  final int idTransaksi;
  final int idBarang;
  final int jumlahBarang;
  final double subtotal;
  final Barang? barang;

  DetailTransaksi({
    required this.idDetailTransaksi,
    required this.idTransaksi,
    required this.idBarang,
    required this.jumlahBarang,
    required this.subtotal,
    this.barang,
  });

  factory DetailTransaksi.fromJson(Map<String, dynamic> json) {
    try {
      return DetailTransaksi(
        idDetailTransaksi: json['id_detail_transaksi']?.toInt() ?? 0,
        idTransaksi: json['id_transaksi']?.toInt() ?? 0,
        idBarang: json['id_barang']?.toInt() ?? 0,
        jumlahBarang: json['jumlah_barang']?.toInt() ?? 0,
        subtotal: (json['subtotal'] ?? 0).toDouble(),
        barang: json['barang'] != null ? Barang.fromJson(json['barang']) : null,
      );
    } catch (e) {
      print('Error parsing DetailTransaksi: $e');
      print('Problematic JSON: $json');
      rethrow;
    }
  }
}

class Transaksi {
  final int idTransaksi;
  final int idPembeli;
  final DateTime tanggalTransaksi;
  final double totalHarga;
  final String statusTransaksi;
  final List<DetailTransaksi> detailTransaksi;

  Transaksi({
    required this.idTransaksi,
    required this.idPembeli,
    required this.tanggalTransaksi,
    required this.totalHarga,
    required this.statusTransaksi,
    required this.detailTransaksi,
  });

  factory Transaksi.fromJson(Map<String, dynamic> json) {
    try {
      print('Parsing Transaksi JSON: $json'); // Debug print

      DateTime tanggal;
      if (json['tanggal_transaksi'] is String) {
        tanggal = DateTime.parse(json['tanggal_transaksi']);
      } else if (json['tanggal_transaksi'] is Map) {
        tanggal = DateTime.parse(json['tanggal_transaksi']['date']);
      } else {
        tanggal = DateTime.now();
      }

      double total;
      if (json['total_harga'] is int) {
        total = (json['total_harga'] as int).toDouble();
      } else if (json['total_harga'] is double) {
        total = json['total_harga'];
      } else if (json['total_harga'] is String) {
        total = double.parse(json['total_harga']);
      } else {
        total = 0.0;
      }


      List<DetailTransaksi> details = [];
      if (json['detail_transaksi'] != null) {
        if (json['detail_transaksi'] is List) {
          details = (json['detail_transaksi'] as List)
              .map((detail) => DetailTransaksi.fromJson(detail))
              .toList();
        }
      }

      String status = json['status_transaksi'] ?? 'menunggu konfirmasi';
      if (status.isEmpty) {
        status = 'menunggu konfirmasi';
      }

      print('Parsed status_transaksi: $status'); 

      return Transaksi(
        idTransaksi: json['id_transaksi'] ?? 0,
        idPembeli: json['id_pembeli'] ?? 0,
        tanggalTransaksi: tanggal,
        totalHarga: total,
        statusTransaksi: status,
        detailTransaksi: details,
      );
    } catch (e) {
      print('Error parsing Transaksi: $e');
      print('JSON data: $json');
      rethrow;
    }
  }
}
