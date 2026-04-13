<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        $admin = User::firstOrCreate(
            ['email' => 'admin@vendora.id'],
            [
                'name' => 'Superadmin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('superadmin');
    }
}