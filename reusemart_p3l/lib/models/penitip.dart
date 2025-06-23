class Penitip {
  final int idPenitip;
  final String namaPenitip;
  final String? alamatPenitip;
  final String? emailPenitip;
  final String? noTelpPenitip;
  final double saldoPenitip;
  final int poinPenitip;
  final double? ratingPenitip;
  final String? usernamePenitip;
  final String? statusPenitip;

  Penitip({
    required this.idPenitip,
    required this.namaPenitip,
    this.alamatPenitip,
    this.emailPenitip,
    this.noTelpPenitip,
    required this.saldoPenitip,
    required this.poinPenitip,
    this.ratingPenitip,
    this.usernamePenitip,
    this.statusPenitip,
  });

  factory Penitip.fromJson(Map<String, dynamic> json) {
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

    return Penitip(
      idPenitip: toInt(json['id_penitip']),
      namaPenitip: toString(json['nama_penitip']) ?? '',
      alamatPenitip: toString(json['alamat_penitip']),
      emailPenitip: toString(json['email_penitip']),
      noTelpPenitip: toString(json['noTelp_penitip']),
      saldoPenitip: toDouble(json['saldo_penitip']),
      poinPenitip: toInt(json['poin_penitip']),
      ratingPenitip: json['rating_penitip'] != null ? toDouble(json['rating_penitip']) : null,
      usernamePenitip: toString(json['username_penitip']),
      statusPenitip: toString(json['status_penitip']),
    );
  }
} 