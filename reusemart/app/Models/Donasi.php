<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';
    public $timestamps = false;

    protected $fillable = ['id_barang', 'id_request_donasi', 'tanggal_donasi', 'nama_penerima'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function requestDonasi()
    {
        return $this->belongsTo(RequestDonasi::class, 'id_request_donasi');
    }
}
