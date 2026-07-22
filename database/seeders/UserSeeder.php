<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Front Desk',
                'email' => 'frontdesk@example.com',
                'password' => 'password',
                'role' => 'front_desk',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => 'password',
                'role' => 'manager',
            ],
            [
                'name' => 'Customer One',
                'email' => 'customer@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Guest Customer',
                'email' => 'guest@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'James Cruz',
                'email' => 'james.cruz@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Sofia Reyes',
                'email' => 'sofia.reyes@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
