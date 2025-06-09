<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapotUts extends Model
{
    protected $table = 'rapot_uts';

    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }
}
