<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'System Administrator',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'              => 'Juan Dela Cruz',
            'email'             => 'senior@example.com',
            'password'          => Hash::make('password'),
            'role'              => 'user',
            'membership_id'     => 'SC-20260001',
            'date_of_birth'     => '1955-03-15',
            'contact_number'    => '09171234567',
            'address'           => '123 Mabini St., Barangay Sample, Quezon City',
            'membership_status' => 'active',
            'membership_date'   => '2024-01-10',
            'expiry_date'       => '2027-01-10',
            'notes'             => 'Sample senior citizen member.',
        ]);

        User::create([
            'name'              => 'Maria Santos',
            'email'             => 'maria.santos@example.com',
            'password'          => Hash::make('password'),
            'role'              => 'user',
            'membership_id'     => 'SC-20260002',
            'date_of_birth'     => '1948-07-22',
            'contact_number'    => '09189876543',
            'address'           => '45 Rizal Ave., Manila',
            'membership_status' => 'active',
            'membership_date'   => '2023-06-01',
            'expiry_date'       => '2026-06-01',
        ]);

        User::create([
            'name'              => 'Pedro Reyes',
            'email'             => 'pedro.reyes@example.com',
            'password'          => Hash::make('password'),
            'role'              => 'user',
            'membership_id'     => 'SC-20260003',
            'date_of_birth'     => '1952-11-05',
            'contact_number'    => '09201234567',
            'address'           => '78 Bonifacio St., Makati',
            'membership_status' => 'pending',
            'membership_date'   => null,
            'expiry_date'       => null,
        ]);
    }
}