import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/transaksi.dart';

class TransaksiService {
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  Future<List<Transaksi>> getTransaksiHistory(int idPembeli) async {
    try {
      print('Fetching transaction history for id_pembeli: $idPembeli');
      final response = await http.get(
        Uri.parse('$baseUrl/pembeli/$idPembeli/transaksi'),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
      );

      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final Map<String, dynamic> responseData = json.decode(response.body);
        if (responseData['data'] == null) {
          print('Error: Data not found in response');
          return [];
        }
        final List<dynamic> data = responseData['data'];
        return data.map((json) => Transaksi.fromJson(json)).toList();
      } else if (response.statusCode == 404) {
        print('No transactions found for pembeli ID: $idPembeli');
        return [];
      } else {
        final errorData = json.decode(response.body);
        print('Error: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
        throw Exception('Gagal memuat riwayat transaksi: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
      }
    } catch (e) {
      print('Error fetching transaction history: $e');
      if (e is FormatException) {
        throw Exception('Format data tidak valid. Silakan coba lagi.');
      }
      throw Exception('Gagal memuat riwayat transaksi: $e');
    }
  }
}
