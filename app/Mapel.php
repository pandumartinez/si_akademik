<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapels';

    protected $guarded = [];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder->orderBy('mapels.kelompok')->orderBy('nama_mapel');
        });
    }

    public function jadwal()
    {
        return $this->hasMany('App\Jadwal');
    }

    public function guru()
    {
        return $this->belongsToMany('App\Guru', 'App\Jadwal')
            ->distinct('gurus.id');
    }
}
