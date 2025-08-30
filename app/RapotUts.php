<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RapotUts extends Model
{
    use LogsActivity;
    
    protected $table = 'rapot_uts';

    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel');
    }

    public function siswa()
    {
        return $this->hasOneThrough(
            Siswa::class,KelasSiswa::class, 'id','id','kelas_siswa_id', 'siswa_id'
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
    }
}
