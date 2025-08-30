<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Mapel extends Model
{
    use LogsActivity;

    protected $table = 'mapels';

    protected $guarded = [];

    protected $with = ['kelompok'];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder
                ->orderBy(
                    KelompokMapel::select('kode')
                        ->whereColumn('kelompok_mapel.id', 'mapels.kelompok_mapel')
                        ->latest()
                        ->limit(1)
                )
                ->orderBy('nama_mapel');
        });
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokMapel::class, 'kelompok_mapel', 'id');
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

    public function nilai()
    {
        return $this->hasMany('App\Nilai');
    }

    public function rapotUts()
    {
        return $this->hasMany('App\RapotUts');
    }

    public function rapotUas()
    {
        return $this->hasMany('App\RapotUas');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }
}
