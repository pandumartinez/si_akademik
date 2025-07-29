<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $guarded = [];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder->orderBy('jabatan.nama_jabatan');
        });
    }
}
