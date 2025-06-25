<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Periode extends Model
{
    protected $table = 'periode';

    protected $guarded = [];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date',
        'aktif' => 'boolean',
    ];

    public $timestamps = false;

    public function __tostring()
    {
        return $this->tahunAjaran . ' ' . ucfirst($this->semester);
    }

    public function getSemesterAttribute($value)
    {
        return ucfirst($value);
    }

    public function getTahunAjaranAttribute()
    {
        $tahunMulai = $this->tahun;
        $tahunSelesai = $this->tahun + 1;
        return "$tahunMulai/$tahunSelesai";
    }

    public static function id()
    {
        $id = Cache::get('id_periode_aktif');

        if ($id !== null) {
            return $id;
        }

        $id = Periode::where('aktif', '=', true)->first()->id;

        Cache::put('id_periode_aktif', $id);

        return $id;
    }

    public static function aktif()
    {
        return Periode::where('aktif', '=', true)->first();
    }
}
