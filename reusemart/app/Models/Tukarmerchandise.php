<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tukarmerchandise extends Model
{
    protected $table = 'tukarmerchandise';
    protected $primaryKey = 'id_tukar_merch';
    public $timestamps = false;

    protected $fillable = ['id_pembeli', 'id_merchandise', 'tanggal_ambil_merch', 'status_merch'];

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class, 'id_merchandise');
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli');
    }
}
