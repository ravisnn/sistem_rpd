<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Realisasi extends Model
{
    use HasFactory, LogsActivity;
    protected $primaryKey = 'id_realisasi';
    protected $fillable = [
        'kegiatan', 'uraians', 'komponen', 'jenis_belanja', 'unit_kerja', 'output', 'akun_id', 'uraian_id', 'target',
        'jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'
    ];
    public function akun() { return $this->belongsTo(Akun::class, 'akun_id', 'id_akun'); }
    public function uraian() { return $this->belongsTo(Uraian::class, 'uraian_id', 'id_uraian'); }
    public function getActivitylogOptions(): LogOptions
    {
            return LogOptions::defaults()
            ->logOnly(['uraians','jan','feb','mar','apr','mei','jun','jul','agt','sep','okt','nov','des'])
            ->logOnlyDirty()
            ->useLogName('realisasi');
    }
}
