<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IkpaTarget extends Model
{
    protected $primaryKey = 'id_ikpa_target';
    protected $fillable = [
        'jenis_belanja', 'triwulan', 'tahun', 'target'
    ];
}
