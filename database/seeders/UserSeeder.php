<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory(7)->create();
    }
}
