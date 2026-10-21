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
            'name' => 'Kasir Branch A',
            'email' => 'branchA@shoewash.com',
            'password' => Hash::make('password123'), // Password aman terenkripsi
            'branch_id' => 1, // Terhubung ke Branch ID 1
        ]);

        User::create([
            'name' => 'Kasir Branch B',
            'email' => 'branchB@shoewash.com',
            'password' => Hash::make('password123'),
            'branch_id' => 2, // Terhubung ke Branch ID 2
        ]);
    }
}
