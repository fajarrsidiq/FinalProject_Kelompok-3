<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap')->after('id');
            $table->enum('role', ['owner', 'manager', 'supervisor', 'kasir', 'gudang'])->default('kasir');
            $table->boolean('is_active')->default(true);
            $table->dropColumn('name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'role', 'is_active']);
            $table->string('name');
        });
    }
};