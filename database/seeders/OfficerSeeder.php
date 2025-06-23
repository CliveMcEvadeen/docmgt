<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OfficerSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate([
            'email' => 'officer@example.com',
        ], [
            'firstname' => 'Officer',
            'lastname' => 'User',
            'role' => 'officer',
            'password' => Hash::make('Officer123!'),
            'email_verified_at' => now(),
        ]);
    }
}
