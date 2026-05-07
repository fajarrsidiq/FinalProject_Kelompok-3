<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama_lengkap' => 'Pak Jayusman',
            'email' => 'owner@minishop.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'is_active' => true,
            'cabang_id' => null
        ]);
    }
}