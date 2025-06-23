import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/penitip.dart';
import '../models/barang.dart';

class PenitipService {
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  Future<Penitip> getPenitipProfile(int idUser) async {
    try {
      print('Fetching penitip profile for id_user: $idUser');
      final response = await http.get(
        Uri.parse('$baseUrl/penitip/user/$idUser'),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
      );
      
      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        if (responseData['data'] == null) {
          print('Error: Data not found in response');
          throw Exception('Data penitip tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
        }
        final Map<String, dynamic> data = responseData['data'];
        
        // Debug: Print each field and its type
        print('Debug - Data fields:');
        data.forEach((key, value) {
          print('$key: $value (${value.runtimeType})');
        });
        
        return Penitip.fromJson(data);
      } else if (response.statusCode == 404) {
        print('Error: Penitip not found');
        throw Exception('Profil penitip tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
      } else {
        final errorData = json.decode(response.body);
        print('Error: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
        throw Exception('Gagal memuat profil: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
      }
    } catch (e) {
      print('Error in getPenitipProfile: $e');
      throw Exception('Terjadi kesalahan: $e');
    }
  }

  Future<List<Barang>> getPenitipBarang(int idPenitip) async {
    try {
      print('Fetching barang for penitip id: $idPenitip');
      final response = await http.get(
        Uri.parse('$baseUrl/penitip/$idPenitip/barang'),
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
      );
      
      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        if (responseData['data'] == null) {
          return [];
        }
        final List<dynamic> data = responseData['data'];
        return data.map((json) => Barang.fromJson(json)).toList();
      } else if (response.statusCode == 404) {
        return [];
      } else {
        final errorData = json.decode(response.body);
        throw Exception('Gagal memuat data barang: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
      }
    } catch (e) {
      print('Error in getPenitipBarang: $e');
      throw Exception('Terjadi kesalahan: $e');
    }
  }
} 