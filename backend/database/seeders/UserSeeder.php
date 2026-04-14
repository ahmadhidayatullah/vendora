<?php

namespace Database\Seeders;

use App\Enums\User\UserRole;
use App\Enums\Vendor\VendorStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@vendora.test'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole(UserRole::ADMIN->value);

        // Vendor
        $vendorUser = User::firstOrCreate(
            ['email' => 'vendor@vendora.test'],
            [
                'name'     => 'Vendor One',
                'password' => Hash::make('password'),
            ]
        );
        $vendorUser->assignRole(UserRole::VENDOR->value);

        Vendor::firstOrCreate(
            ['user_id' => $vendorUser->id],
            [
                'name'        => 'Vendor One Store',
                'slug'        => 'vendor-one-store',
                'email'       => 'vendor@vendora.test',
                'description' => 'First test vendor',
                'status'      => VendorStatus::ACTIVE,
            ]
        );

        // Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@vendora.test'],
            [
                'name'     => 'Customer One',
                'password' => Hash::make('password'),
            ]
        );
        $customer->assignRole(UserRole::CUSTOMER->value);
    }
}