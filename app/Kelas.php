<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $guarded = [];

    public static function booted()
    {
        static::addGlobalScope('defaultSort', function (Builder $builder) {
            $builder->orderBy('kelas.nama_kelas');
        });
    }

    public function waliKelas()
    {
        return $this->belongsTo('App\Guru', 'wali_kelas');
    }

    public function jadwal()
    {
        return $this->hasMany('App\Jadwal');
    }

    public function mapel()
    {
        return $this->belongsToMany('App\Mapel', 'App\Jadwal')
            ->distinct('mapels.id');
    }

    public function mapelGuru(Guru $guru)
    {
        return $this->mapel()
            ->whereHas('jadwal', function ($query) use ($guru) {
                $query->where('jadwals.guru_id', '=', $guru->id);
            });
    }

    public function siswa()
    {
        return $this->belongsToMany('App\Siswa', 'App\KelasSiswa')
            ->withPivot('id');
    }
}
