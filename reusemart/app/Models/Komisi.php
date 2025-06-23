<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    protected $table = 'komisi';
    protected $primaryKey = 'id_komisi';
    protected $fillable = [
        'tanggal_masuk', 'tanggal_laku',
        'komisi_pegawai', 'komisi_perusahaan', 'bonus_penitip',
        'id_pegawai', 'id_penitip', 'id_transaksi',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
