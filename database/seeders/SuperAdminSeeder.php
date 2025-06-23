<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'role' => 'super_admin',
            'password' => Hash::make('SuperAdmin123!'),
            'email_verified_at' => now(),
        ]);
    }
}
