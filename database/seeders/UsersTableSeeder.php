<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@fio.com',
                'password' => Hash::make('adminpassword'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@fio.com',
                'password' => Hash::make('userpassword'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more users as needed
        ]);
    }
}