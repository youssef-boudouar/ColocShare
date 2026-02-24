<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@clocshare.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_banned' => false,
                'reputation' => 100,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@clocshare.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_banned' => false,
                'reputation' => 0,
            ]
        );
    }
}
