<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model {
    use HasFactory;
    protected $primaryKey = 'id_akun';
    protected $fillable = ['kode','nama'];
}
