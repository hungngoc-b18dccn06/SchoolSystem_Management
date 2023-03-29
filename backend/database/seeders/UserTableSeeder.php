<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        //admin
        User::create([
            "email" => "admin@base.vn",
            "password" => Hash::make('password'),
            "first_name" => "Admin",
            "last_name" => "Admin",
            "role" => Role::ADMIN,
            "status" => 1
        ]);

        //User
        User::create([
            "email" => "editor@base.vn",
            "password" => Hash::make('password'),
            "first_name" => "User",
            "last_name" => "User",
            "role" => Role::USER,
            "status" => 1
        ]);

        //TEACHER
        User::create([
            "email" => "teacher@base.vn",
            "password" => Hash::make('password'),
            "first_name" => "Teacher",
            "last_name" => "Teacher",
            "role" => Role::TEACHER,
            "status" => 1
        ]);
    }
}
