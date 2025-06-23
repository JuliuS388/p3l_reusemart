<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $table = 'kategori_barang';

    protected $primaryKey = 'id_kategori'; 

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_kategori',
    ];
}
