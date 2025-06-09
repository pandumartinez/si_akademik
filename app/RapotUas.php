<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapotUas extends Model
{
    protected $table = 'rapot_uas';

    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }
}
