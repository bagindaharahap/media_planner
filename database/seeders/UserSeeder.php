<?php

namespace Database\Seeders;

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
        $users = [
            [
                'name' => 'Adelsa Fitri',
                'email' => 'adelsa@plannerx.com',
                'role' => 'Admin',
                'status' => 'Aktif',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Dina Rahmawati',
                'email' => 'dina@plannerx.com',
                'role' => 'Content Planner',
                'status' => 'Aktif',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Lisa Black',
                'email' => 'lisa@plannerx.com',
                'role' => 'Editor Video',
                'status' => 'Aktif',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Putri Ayu',
                'email' => 'putri@plannerx.com',
                'role' => 'Copywriter',
                'status' => 'Nonaktif',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@plannerx.com',
                'role' => 'Desain Grafis',
                'status' => 'Aktif',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}