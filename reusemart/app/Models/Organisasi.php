<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $table = 'organisasi';
    protected $primaryKey = 'id_organisasi';
    public $timestamps = false;

    protected $fillable = ['nama_organisasi', 'alamat_organisasi'];
}
