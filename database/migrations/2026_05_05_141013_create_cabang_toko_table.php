<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cabang_toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko', 100);
            $table->text('alamat');
            $table->string('kota', 50);
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cabang_toko');
    }
};