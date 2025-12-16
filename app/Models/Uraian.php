<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uraian extends Model {
    use HasFactory;
    protected $primaryKey = 'id_uraian';
    protected $fillable = ['kode','nama'];
}
