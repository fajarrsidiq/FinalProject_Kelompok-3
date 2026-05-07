<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_mutasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabang_toko');
            $table->foreignId('barang_id')->constrained('barang');
            $table->foreignId('petugas_id')->constrained('users');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->integer('qty');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_mutasi');
    }
};