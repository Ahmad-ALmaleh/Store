<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Ahmad',
            'email' => 'ahmad@ahmad.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Ali',
            'email' => 'ali@ali.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
