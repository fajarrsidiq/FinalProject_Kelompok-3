<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabang_toko');
            $table->foreignId('kasir_id')->constrained('users');
            $table->string('no_invoice', 50)->unique();
            $table->decimal('total_belanja', 12, 0);
            $table->decimal('diskon', 12, 0)->default(0);
            $table->decimal('total_bayar', 12, 0);
            $table->decimal('tunai', 12, 0);
            $table->decimal('kembali', 12, 0);
            $table->datetime('tanggal_transaksi');
            $table->enum('status', ['selesai', 'batal'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};