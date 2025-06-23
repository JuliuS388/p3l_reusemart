<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penitip extends Model
{
    protected $table = 'penitip';
    protected $primaryKey = 'id_penitip';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_penitip',
        'alamat_penitip',
        'email_penitip',
        'noTelp_penitip',
        'saldo_penitip',
        'nominal_tarik',
        'poin_penitip',
        'rating_penitip',
        'username_penitip',
        'status_penitip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_penitip');
    }

    public function updateRating()
    {
        $barangIds = $this->barang()->pluck('id_barang');

        if ($barangIds->isEmpty()) {
            $this->rating_penitip = null;
            $this->save();
            return;
        }

        $avgRating = \DB::table('detail_transaksi as dt')
            ->join('transaksi as t', 'dt.id_transaksi', '=', 't.id_transaksi')
            ->whereIn('dt.id_barang', $barangIds)
            ->where('t.status_transaksi', 'Selesai')
            ->whereNotNull('dt.rating')
            ->avg('dt.rating');

        $this->rating_penitip = $avgRating ? round($avgRating, 2) : null;
        $this->save();
    }
}
