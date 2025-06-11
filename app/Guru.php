<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;

    protected $table = 'gurus';

    protected $guarded = [];

    protected $casts = [
        'tgl_lahir' => 'date:Y-m-d',
    ];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder->orderBy('gurus.nama_guru');
        });
    }

    public function getAbsenHariIniAttribute()
    {
        return $this->absenHariIni()->first();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'nip', 'nip');
    }

    public function jadwal()
    {
        return $this->hasMany('App\Jadwal');
    }

    public function kelas()
    {
        return $this->belongsToMany('App\Kelas', 'App\Jadwal')
            ->distinct('kelas.id');
    }

    public function mapel()
    {
        return $this->belongsToMany('App\Mapel', 'App\Jadwal')
            ->distinct('mapels.id');
    }

    public function kelasWali()
    {
        return $this->hasOne('App\Kelas', 'wali_kelas');
    }

    public function deskripsi()
    {
        return $this->hasOne('App\Deskripsi');
    }

    public function absen()
    {
        return $this->hasMany('App\AbsenGuru');
    }

    public function absenHariIni()
    {
        return $this->hasMany('App\AbsenGuru')
            ->whereDate('created_at', '=', date('Y-m-d'));
    }
}
