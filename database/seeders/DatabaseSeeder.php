<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin / moderator account. Credentials can be overridden via the
        // ADMIN_EMAIL and ADMIN_PASSWORD environment variables. updateOrCreate
        // keeps this idempotent so re-seeding won't create duplicates.
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@freedomwall.com')],
            [
                'name' => 'Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@12345')),
                'email_verified_at' => now(),
            ]
        );
    }
}
