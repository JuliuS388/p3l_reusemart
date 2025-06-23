import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class LoginPage extends StatefulWidget {
  const LoginPage({Key? key}) : super(key: key);

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  bool _isLoading = false;
  String? _errorMessage;

  Future<void> _login() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });
    
    // Gunakan IP address komputer Anda di jaringan yang sama dengan device Android
    // Contoh: 192.168.1.5 (ganti sesuai IP address komputer Anda)
    final url = Uri.parse('http://10.0.2.2:8000/api/login'); // 10.0.2.2 adalah localhost untuk Android Emulator
    
    try {
      print('Attempting to login with URL: $url');
      final response = await http.post(
        url,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json', // Tambahkan header Accept
        },
        body: jsonEncode({
          'email': _emailController.text,
          'password': _passwordController.text,
        }),
      );
      
      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        print('Login response data: $data');
        
        if (data['role'] == 'pembeli' || data['role'] == 'penitip') {
          final userData = data['user'];
          print('User data: $userData');
          
          if (userData == null || userData['id_user'] == null) {
            setState(() {
              _errorMessage = 'Data pengguna tidak valid';
            });
            return;
          }

          // Navigate to appropriate home page based on role
          if (data['role'] == 'pembeli') {
            Navigator.pushReplacementNamed(
              context,
              '/home',
              arguments: {
                'id_user': userData['id_user'],
                'id_pembeli': userData['id_pembeli'],
                'nama': userData['nama'],
                'email': userData['email'],
                'role': data['role'],
              },
            );
          } else if (data['role'] == 'penitip') {
            Navigator.pushReplacementNamed(
              context,
              '/penitip-home',
              arguments: {
                'id_user': userData['id_user'],
                'id_penitip': userData['id_penitip'],
                'nama': userData['nama'],
                'email': userData['email'],
                'role': data['role'],
              },
            );
          }
        } else {
          setState(() {
            _errorMessage = 'Akun ini bukan pembeli atau penitip';
          });
        }
      } else {
        final error = jsonDecode(response.body);
        setState(() {
          _errorMessage = error['message'] ?? 'Login gagal: Status ${response.statusCode}';
        });
      }
    } catch (e) {
      print('Error during login: $e');
      setState(() {
        _errorMessage = 'Terjadi kesalahan: $e';
      });
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Login'),
        backgroundColor: Colors.green,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextField(
              controller: _emailController,
              decoration: const InputDecoration(
                labelText: 'Email',
                border: OutlineInputBorder(),
              ),
              keyboardType: TextInputType.emailAddress,
            ),
            const SizedBox(height: 16),
            TextField(
              controller: _passwordController,
              decoration: const InputDecoration(
                labelText: 'Password',
                border: OutlineInputBorder(),
              ),
              obscureText: true,
            ),
            const SizedBox(height: 24),
            if (_errorMessage != null)
              Padding(
                padding: const EdgeInsets.only(bottom: 16),
                child: Text(
                  _errorMessage!,
                  style: const TextStyle(color: Colors.red),
                ),
              ),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: _isLoading ? null : _login,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.green,
                  padding: const EdgeInsets.symmetric(vertical: 16),
                ),
                child: _isLoading
                    ? const CircularProgressIndicator(color: Colors.white)
                    : const Text(
                        'Login',
                        style: TextStyle(fontSize: 16),
                      ),
              ),
            ),
            const SizedBox(height: 16),
            TextButton(
              onPressed: () {
                Navigator.pushNamed(context, '/register');
              },
              child: const Text('Belum punya akun? Daftar di sini'),
            ),
          ],
        ),
      ),
    );
  }
}
