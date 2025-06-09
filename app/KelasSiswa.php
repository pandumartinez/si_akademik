<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    protected $table = 'kelas_siswa';

    protected $guarded = [];

    public $timestamps = false;

    public static function booted()
    {
        static::creating(function (KelasSiswa $model) {
            $model->periode_id = Periode::id();
        });

        static::addGlobalScope('aktif', function (Builder $builder) {
            $builder->where('kelas_siswa.periode_id', '=', Periode::id());
        });
    }
}
