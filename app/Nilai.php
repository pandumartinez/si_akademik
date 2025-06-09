<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';

    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }
}
