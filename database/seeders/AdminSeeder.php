<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@plannerx.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@plannerx.com',
                'password' => Hash::make('admin123'),
                'role' => 'Admin',
                'status' => 'Aktif',
            ]);
        }

        // Tambahkan beberapa user demo
        $demoUsers = [
            [
                'name' => 'Content Planner Demo',
                'email' => 'planner@plannerx.com',
                'password' => Hash::make('planner123'),
                'role' => 'Content Planner',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Editor Video Demo',
                'email' => 'editor@plannerx.com',
                'password' => Hash::make('editor123'),
                'role' => 'Editor Video',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Copywriter Demo',
                'email' => 'copy@plannerx.com',
                'password' => Hash::make('copy123'),
                'role' => 'Copywriter',
                'status' => 'Aktif',
            ],
        ];

        foreach ($demoUsers as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }
    }
}