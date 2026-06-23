<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        $customerRole = \App\Models\Role::where('slug', 'customer')->first();

        if ($adminRole) {
            \App\Models\User::create([
                'name' => 'Super Admin',
                'email' => 'admin@watchstore.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => $adminRole->id,
                'phone' => '081234567890',
            ]);
        }

        if ($customerRole) {
            \App\Models\User::create([
                'name' => 'John Doe',
                'email' => 'customer@watchstore.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => $customerRole->id,
                'phone' => '081234567891',
                'address' => 'Jl. Kebon Jeruk No. 12',
            ]);
        }
    }
}
