<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {email?} {--password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset admin password for the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@example.com';
        $password = $this->option('password');

        // Find admin user
        $admin = User::where('email', $email)->where('role', 'admin')->first();

        if (!$admin) {
            $this->error("Admin user with email '{$email}' not found.");
            return 1;
        }

        // Update password
        $admin->update([
            'password' => Hash::make($password)
        ]);

        $this->info("Admin password reset successfully!");
        $this->line("Email: {$email}");
        $this->line("Password: {$password}");

        return 0;
    }
}
