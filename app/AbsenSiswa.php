<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenSiswa extends Model
{
    protected $table = 'absensi_siswa';

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }
}
