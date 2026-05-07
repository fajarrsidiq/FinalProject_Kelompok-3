<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang_toko';
    protected $fillable = ['nama_toko', 'alamat', 'kota', 'telepon'];
}