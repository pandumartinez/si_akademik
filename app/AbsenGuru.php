<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenGuru extends Model
{
    protected $table = 'absensi_guru';

    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo('App\Guru');
    }
}
