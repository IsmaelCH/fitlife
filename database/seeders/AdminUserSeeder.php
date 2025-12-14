<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ehb.be'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'is_admin' => true,
                'password' => bcrypt('Password!321'),
            ]
        );
    }
}
