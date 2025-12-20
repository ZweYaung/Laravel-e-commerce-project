<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'], // Identify the record
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
            ]
        );
    }
}
