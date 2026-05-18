<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    
    protected $fillable = [
        'cabang_id', 'kategori_id', 'kode_barang', 'nama_barang',
        'harga_beli', 'harga_jual', 'stok', 'stok_minimal', 'satuan'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}