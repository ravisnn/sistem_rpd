<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_output';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['kode','nama'];

    public function kegiatans()
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_output', 'output_id', 'kegiatan_id');
    }
}
