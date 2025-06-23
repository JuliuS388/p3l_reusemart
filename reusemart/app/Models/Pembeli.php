<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_pembeli',
        'alamat_pembeli',
        'no_telp_pembeli'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pembeli', 'id_pembeli');
    }

    public function alamat()
    {
        return $this->hasOne(Alamat::class, 'id_pembeli', 'id_pembeli');
    }
}