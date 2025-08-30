<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pengaturan extends Model
{
    use LogsActivity;

    protected $table = 'pengaturan';

    protected $guarded = [];

    public static function getValue(string $key)
    {
        $pengaturan = static::firstWhere('key', '=', $key);

        if (!$pengaturan)
            return null;

        if (in_array($key, ['predikat', 'daftar_buka_absen_siswa']))
            return json_decode($pengaturan->value);

        return $pengaturan->value;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }
}
