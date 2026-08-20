<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@blossom.ng'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Blossom',
                'password' => Hash::make('blossom2024'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: admin@blossom.ng / blossom2024');
    }
}
