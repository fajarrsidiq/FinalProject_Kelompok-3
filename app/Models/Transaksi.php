<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    
    protected $fillable = [
        'cabang_id', 'kasir_id', 'no_invoice', 'total_belanja',
        'diskon', 'total_bayar', 'tunai', 'kembali', 'tanggal_transaksi', 'status'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}