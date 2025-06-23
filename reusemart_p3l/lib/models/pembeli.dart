class Pembeli {
  final int idPembeli;
  final int idUser;
  final String namaPembeli;
  final String? emailPembeli;
  final String? noTelpPembeli;
  final String? usernamePembeli;
  final int poin;
  final Alamat? alamat;

  Pembeli({
    required this.idPembeli,
    required this.idUser,
    required this.namaPembeli,
    this.emailPembeli,
    this.noTelpPembeli,
    this.usernamePembeli,
    required this.poin,
    this.alamat,
  });

  factory Pembeli.fromJson(Map<String, dynamic> json) {
    // Helper function untuk konversi ke int
    int toInt(dynamic value) {
      if (value == null) return 0;
      if (value is int) return value;
      if (value is String) return int.tryParse(value) ?? 0;
      return 0;
    }

    // Helper function untuk konversi ke String
    String? toString(dynamic value) {
      if (value == null) return null;
      return value.toString();
    }

    return Pembeli(
      idPembeli: toInt(json['id_pembeli']),
      idUser: toInt(json['id_user']),
      namaPembeli: toString(json['nama_pembeli']) ?? '',
      emailPembeli: toString(json['email_pembeli']),
      noTelpPembeli: toString(json['noTelp_pembeli']),
      usernamePembeli: toString(json['username_pembeli']),
      poin: toInt(json['poin']),
      alamat: json['alamat'] != null ? Alamat.fromJson(json['alamat']) : null,
    );
  }
}

class Alamat {
  final int idAlamat;
  final int idPembeli;
  final String? alamatLengkap;
  final int kodePos;

  Alamat({
    required this.idAlamat,
    required this.idPembeli,
    this.alamatLengkap,
    required this.kodePos,
  });

  factory Alamat.fromJson(Map<String, dynamic> json) {
    // Helper function untuk konversi ke int
    int toInt(dynamic value) {
      if (value == null) return 0;
      if (value is int) return value;
      if (value is String) return int.tryParse(value) ?? 0;
      return 0;
    }

    // Helper function untuk konversi ke String
    String? toString(dynamic value) {
      if (value == null) return null;
      return value.toString();
    }

    return Alamat(
      idAlamat: toInt(json['id_alamat']),
      idPembeli: toInt(json['id_pembeli']),
      alamatLengkap: toString(json['alamat_lengkap']),
      kodePos: toInt(json['kode_pos']),
    );
  }
}
