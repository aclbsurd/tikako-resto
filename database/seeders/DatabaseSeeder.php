<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Owner Tikako',
            'email' => 'admin@tikako.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin', 
        ]);

        // User::create([
        //     'name' => 'Pelanggan Tes',
        //     'email' => 'user@test.com',
        //     'password' => Hash::make('12345678'),
        //     'role' => 'user',
        // ]);
    }
}