import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/pembeli.dart';

class PembeliService {
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  Future<Pembeli> getPembeliProfile(int idUser) async {
    try {
      print('Fetching pembeli profile for id_user: $idUser');
      final response = await http.get(
        Uri.parse('$baseUrl/pembeli/user/$idUser'),
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
          throw Exception('Data pembeli tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
        }
        final Map<String, dynamic> data = responseData['data'];
        
        // Debug: Print each field and its type
        print('Debug - Data fields:');
        data.forEach((key, value) {
          print('$key: $value (${value.runtimeType})');
        });
        
        if (data['alamat'] != null) {
          print('Debug - Alamat fields:');
          data['alamat'].forEach((key, value) {
            print('$key: $value (${value.runtimeType})');
          });
        }
        
        return Pembeli.fromJson(data);
      } else if (response.statusCode == 404) {
        print('Error: Pembeli not found');
        throw Exception('Profil pembeli tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
      } else {
        final errorData = json.decode(response.body);
        print('Error: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
        throw Exception('Gagal memuat profil: ${errorData['message'] ?? 'Status ${response.statusCode}'}');
      }
    } catch (e) {
      print('Error fetching profile: $e');
      if (e is FormatException) {
        throw Exception('Format data tidak valid. Silakan coba lagi.');
      }
      throw Exception('Gagal memuat profil: $e');
    }
  }
}
