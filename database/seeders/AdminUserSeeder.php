<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('VIVIO_ADMIN_EMAIL', 'admin@vivio.studio')],
            [
                'name' => 'VIVIO Admin',
                'password' => env('VIVIO_ADMIN_PASSWORD', 'change-me-on-first-login'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
