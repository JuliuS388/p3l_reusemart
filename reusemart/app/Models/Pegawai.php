<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'nama_pegawai',
        'id_jabatan',
        'email_pegawai',
        'username_pegawai',
        'tanggal_lahir_pegawai',
        //'id_user'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}


