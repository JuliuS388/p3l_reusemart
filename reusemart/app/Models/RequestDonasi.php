<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDonasi extends Model
{
    protected $table = 'request_donasi';
    protected $primaryKey = 'id_request_donasi';
    public $timestamps = false;

    protected $fillable = ['id_organisasi', 'request', 'status_request'];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi');
    }
}

