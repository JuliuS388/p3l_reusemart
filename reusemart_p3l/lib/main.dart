import 'package:flutter/material.dart';
import 'pages/splash_page.dart';
import 'login_page.dart';
import 'home_page.dart'; // Import halaman home
import 'pages/profile_page.dart';
import 'pages/penitip_home_page.dart';
import 'pages/penitip_profile_page.dart';
import 'pages/penitip_barang_page.dart';
import 'pages/product_detail_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'ReuseMart',
      theme: ThemeData(
        primarySwatch: Colors.green,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      debugShowCheckedModeBanner: false,
      initialRoute: '/',
      routes: {
        '/': (context) => const SplashPage(),
        '/login': (context) => const LoginPage(),
        '/home': (context) => const HomePage(),
        '/profile': (context) => const ProfilePage(),
        '/penitip-home': (context) => const PenitipHomePage(),
      },
      onGenerateRoute: (settings) {
        if (settings.name == '/penitip-profile') {
          final args = settings.arguments as Map<String, dynamic>;
          return MaterialPageRoute(
            builder: (context) => PenitipProfilePage(userData: args),
          );
        }
        if (settings.name == '/penitip-barang') {
          final args = settings.arguments as Map<String, dynamic>;
          return MaterialPageRoute(
            builder: (context) => PenitipBarangPage(userData: args),
          );
        }
        if (settings.name == '/product-detail') {
          final args = settings.arguments as Map<String, dynamic>;
          return MaterialPageRoute(
            builder: (context) => ProductDetailPage(barang: args['barang']),
          );
        }
        return null;
      },
    );
  }
}
