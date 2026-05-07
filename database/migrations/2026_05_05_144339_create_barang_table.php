<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabang_toko')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_barang');
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 100);
            $table->decimal('harga_beli', 12, 0);
            $table->decimal('harga_jual', 12, 0);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimal')->default(5);
            $table->string('satuan', 20)->default('pcs');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang');
    }
};