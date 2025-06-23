import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/barang.dart';

class BarangService {
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  Future<List<Barang>> getBarangTersedia() async {
    try {
      final response = await http.get(Uri.parse('$baseUrl/barang/tersedia'));
      
      if (response.statusCode == 200) {
        final List<dynamic> data = json.decode(response.body)['data'];
        return data.map((json) => Barang.fromJson(json)).toList();
      } else {
        throw Exception('Failed to load products');
      }    } catch (e) {
      throw Exception('Error: $e');
    }
  }
}
