<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@zeraay.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01234567890',
            'city' => 'Cairo',
            'state' => 'Cairo',
        ]);

        echo "Admin user created successfully!\n";
        echo "Email: admin@zeraay.com\n";
        echo "Password: password\n";
    }
}
