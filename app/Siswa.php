<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswas';

    protected $guarded = [];

    protected $casts = [
        'tgl_lahir' => 'date:Y-m-d',
    ];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder->orderBy('siswas.nama_siswa');
        });
    }

    public function getKelasSiswaAttribute()
    {
        return $this->kelasSiswa()->first();
    }

    public function getKelasAttribute()
    {
        return $this->kelas()->first();
    }

    public function getAbsenHariIniAttribute()
    {
        return $this->absenHariIni()->first();
    }

    public function kelasSiswa()
    {
        return $this->hasMany('App\KelasSiswa');
    }

    public function kelas()
    {
        return $this->belongsToMany('App\Kelas', 'App\KelasSiswa');
    }

    public function nilai()
    {
        return $this->hasManyThrough('App\Nilai', 'App\KelasSiswa');
    }

    public function rapotUts()
    {
        return $this->hasManyThrough('App\RapotUts', 'App\KelasSiswa');
    }

    public function rapotUas()
    {
        return $this->hasManyThrough('App\RapotUas', 'App\KelasSiswa');
    }

    public function absenHariIni()
    {
        return $this->hasMany('App\AbsenSiswa')
            ->whereDate('created_at', '=', date('Y-m-d'));
    }
}
