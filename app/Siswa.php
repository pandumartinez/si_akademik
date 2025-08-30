<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Siswa extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

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

    public function kelasSiswa()
    {
        return $this->hasMany('App\KelasSiswa');
    }

    public function kelas()
    {
        return $this->belongsToMany('App\Kelas', 'App\KelasSiswa')
            ->withPivot('id');
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

    public function absen()
    {
        return $this->hasMany('App\AbsenSiswa');
    }

    public function absenPeriodeIni()
    {
        $periode = Periode::aktif();

        return $this->absen()
            ->whereBetween('created_at', [$periode->tanggal_awal, $periode->tanggal_akhir]);
    }

    public function jumlahAbsenPeriodeIni($keterangan)
    {
        return $this->absenPeriodeIni()->where('keterangan', '=', $keterangan)->count();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }
}
