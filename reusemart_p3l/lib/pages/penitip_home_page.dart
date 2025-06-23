import 'package:flutter/material.dart';
import '../models/penitip.dart';
import '../services/penitip_service.dart';

class PenitipHomePage extends StatefulWidget {
  final dynamic userData;

  const PenitipHomePage({Key? key, this.userData}) : super(key: key);

  @override
  State<PenitipHomePage> createState() => _PenitipHomePageState();
}

class _PenitipHomePageState extends State<PenitipHomePage> {
  final PenitipService _penitipService = PenitipService();
  Penitip? _penitip;
  bool _isLoading = true;
  String? _errorMessage;
  bool _isInitialized = false;
  int? _userId;

  @override
  void initState() {
    super.initState();
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (!_isInitialized) {
      final args = widget.userData ?? ModalRoute.of(context)?.settings.arguments;
      if (args != null && args['id_user'] != null) {
        _userId = args['id_user'];
        _loadPenitipData();
      }
      _isInitialized = true;
    }
  }

  Future<void> _loadPenitipData() async {
    if (_userId == null) {
      setState(() {
        _errorMessage = 'Data pengguna tidak valid';
        _isLoading = false;
      });
      return;
    }

    try {
      final penitip = await _penitipService.getPenitipProfile(_userId!);
      setState(() {
        _penitip = penitip;
        _isLoading = false;
      });
    } catch (e) {
      setState(() {
        _errorMessage = e.toString();
        _isLoading = false;
      });
    }
  }

  Widget _buildSummaryItem(String label, String value, IconData icon, Color color) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            Icon(icon, color: color, size: 32),
            const SizedBox(height: 8),
            Text(
              label,
              style: const TextStyle(
                fontSize: 14,
                color: Colors.grey,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              value,
              style: const TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final args = widget.userData ?? ModalRoute.of(context)?.settings.arguments;

    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard Penitip'),
        backgroundColor: Colors.green,
      ),
      drawer: Drawer(
        child: ListView(
          padding: EdgeInsets.zero,
          children: [
            UserAccountsDrawerHeader(
              accountName: Text(_penitip?.namaPenitip ?? 'Loading...'),
              accountEmail: Text(_penitip?.emailPenitip ?? 'Loading...'),
              currentAccountPicture: CircleAvatar(
                backgroundColor: Colors.white,
                child: Text(
                  (_penitip?.namaPenitip ?? '?')[0].toUpperCase(),
                  style: const TextStyle(
                    fontSize: 24,
                    color: Colors.green,
                  ),
                ),
              ),
              decoration: const BoxDecoration(
                color: Colors.green,
              ),
            ),
            ListTile(
              leading: const Icon(Icons.home),
              title: const Text('Dashboard'),
              onTap: () {
                Navigator.pop(context);
              },
            ),
            ListTile(
              leading: const Icon(Icons.inventory_2),
              title: const Text('Barang Saya'),
              onTap: () {
                Navigator.pop(context);
                Navigator.pushNamed(context, '/penitip-barang', arguments: args);
              },
            ),
            ListTile(
              leading: const Icon(Icons.person),
              title: const Text('Profil'),
              onTap: () {
                Navigator.pop(context);
                Navigator.pushNamed(context, '/penitip-profile', arguments: args);
              },
            ),
            const Divider(),
            ListTile(
              leading: const Icon(Icons.logout),
              title: const Text('Logout'),
              onTap: () {
                Navigator.pushReplacementNamed(context, '/');
              },
            ),
          ],
        ),
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _errorMessage != null
              ? Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(
                        Icons.error_outline,
                        color: Colors.red,
                        size: 48,
                      ),
                      const SizedBox(height: 16),
                      Text(
                        _errorMessage!,
                        textAlign: TextAlign.center,
                        style: const TextStyle(color: Colors.red),
                      ),
                    ],
                  ),
                )
              : RefreshIndicator(
                  onRefresh: _loadPenitipData,
                  child: SingleChildScrollView(
                    padding: const EdgeInsets.all(16),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Card(
                          child: Padding(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text(
                                  'Selamat Datang,',
                                  style: TextStyle(
                                    fontSize: 16,
                                    color: Colors.grey,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  _penitip?.namaPenitip ?? '',
                                  style: const TextStyle(
                                    fontSize: 24,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                const SizedBox(height: 8),
                                Text(
                                  _penitip?.emailPenitip ?? '',
                                  style: const TextStyle(
                                    fontSize: 14,
                                    color: Colors.grey,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                        const SizedBox(height: 24),
                        const Text(
                          'Ringkasan',
                          style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        const SizedBox(height: 16),
                        GridView.count(
                          crossAxisCount: 2,
                          shrinkWrap: true,
                          physics: const NeverScrollableScrollPhysics(),
                          mainAxisSpacing: 16,
                          crossAxisSpacing: 16,
                          children: [
                            _buildSummaryItem(
                              'Saldo',
                              'Rp ${_penitip?.saldoPenitip.toStringAsFixed(0) ?? '0'}',
                              Icons.account_balance_wallet,
                              Colors.blue,
                            ),
                            _buildSummaryItem(
                              'Poin',
                              '${_penitip?.poinPenitip ?? 0}',
                              Icons.stars,
                              Colors.amber,
                            ),
                            _buildSummaryItem(
                              'Rating',
                              _penitip?.ratingPenitip != null
                                  ? _penitip!.ratingPenitip!.toStringAsFixed(1)
                                  : '-',
                              Icons.star,
                              Colors.orange,
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                ),
    );
  }
} 