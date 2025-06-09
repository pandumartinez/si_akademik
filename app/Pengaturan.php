<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $guarded = [];

    public static function getValue(string $key)
    {
        $pengaturan = static::firstWhere('key', '=', $key);

        if (!$pengaturan)
            return null;

        if ($key === 'predikat')
            return json_decode($pengaturan->value);

        return $pengaturan->value;
    }
}
