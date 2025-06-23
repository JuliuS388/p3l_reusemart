<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = true; 
    protected $keyType = 'int';  

    protected $fillable = [
        'foto_thumbnail',
        'foto1_barang',
        'foto2_barang',
        'kode_produk',
        'nama_barang',
        'tanggal_masuk',
        'tanggal_garansi',
        'harga_barang',
        'status_barang',
        'id_kategori',
        'id_penitip',
        'id_pegawai',
        'id_hunter',              // ditambahkan
        'deskripsi_barang',
        'berat_barang',
        'tanggal_batas_penitipan',
        'perpanjangan',           // ditambahkan
    ];

    public function donasi()
    {
        return $this->hasOne(Donasi::class, 'id_barang');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori', 'id_kategori');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function hunter()
    {
        return $this->belongsTo(Pegawai::class, 'id_hunter');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang');
    }
}
