<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KelompokMapel extends Model
{
    protected $table = 'kelompok_mapel';

    protected $guarded = [];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder->orderBy('kode');
        });
    }
}
