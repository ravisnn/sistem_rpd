<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kegiatan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['kode','nama'];

    public function outputs()
    {
        return $this->belongsToMany(Output::class, 'kegiatan_output', 'kegiatan_id', 'output_id');
    }
}
