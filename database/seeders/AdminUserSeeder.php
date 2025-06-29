<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Sandra Nakawuka',
            'email' => 'nakawukasandra8@gmail.com',
            'password' => Hash::make('Sandra@123'), // Replace with a secure password
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}