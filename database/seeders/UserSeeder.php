<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Test Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('test'),
                'is_admin' => true,
                'email_verified_at' => now()
            ],
            [
                'name' => 'Test User',
                'email' => 'user@test.com',
                'password' => bcrypt('test'),
                'is_admin' => false,
                'email_verified_at' => now()
            ],
            [
                'name' => 'Inactive User',
                'email' => 'inactive@test.com',
                'password' => bcrypt('test'),
                'is_admin' => false,
                'email_verified_at' => now()
            ],
            [
                'name' => 'Unverified User',
                'email' => 'unverified@test.com',
                'password' => bcrypt('test'),
                'is_admin' => false,
                'email_verified_at' => null
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
