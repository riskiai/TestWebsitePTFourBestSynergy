<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Get role IDs
        $adminRoleId = DB::table('roles')->where('role_name', 'admin')->first()->id;
        $customerRoleId = DB::table('roles')->where('role_name', 'customer')->first()->id;

        // Insert admin user
        DB::table('users')->insert([
            'username' => 'admin_user',
            'password' => Hash::make('admin_password'), 
            'name' => 'Admin Name',
            'address' => 'Admin Address',
            'phone_number' => '1234567890',
            'role_id' => $adminRoleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert customer user
        DB::table('users')->insert([
            'username' => 'customer_user',
            'password' => Hash::make('customer_password'), 
            'name' => 'Customer Name',
            'address' => 'Customer Address',
            'phone_number' => '0987654321',
            'role_id' => $customerRoleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
