<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'blossom:create-admin {--email=admin@blossom.ng} {--password=password}';
    protected $description = 'Create or update an admin user for Filament panel';

    public function handle(): int
    {
        $user = User::updateOrCreate(
            ['email' => $this->option('email')],
            [
                'first_name' => 'Admin',
                'last_name' => 'Blossom',
                'password' => bcrypt($this->option('password')),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->info("Admin user ready: {$user->email}");
        return Command::SUCCESS;
    }
}
