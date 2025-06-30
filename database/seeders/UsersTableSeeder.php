<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Admin1',
            'last_name' => 'User1',
            'email' => 'admin1@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]); 
        User::create([
            'name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Alice',
            'last_name' => 'Johnson',
            'email' => 'alice.johnson@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Bob',
            'last_name' => 'Brown',
            'email' => 'bob.brown@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Charlie',
            'last_name' => 'Davis',
            'email' => 'charlie.davis@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Eve',
            'last_name' => 'White',
            'email' => 'eve.white@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Frank',
            'last_name' => 'Green',
            'email' => 'frank.green@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Grace',
            'last_name' => 'Black',
            'email' => 'grace.black@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Hank',
            'last_name' => 'Blue',
            'email' => 'hank.blue@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        User::create([
            'name' => 'Ivy',
            'last_name' => 'Red',
            'email' => 'ivy.red@escuela.ar',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
    }
}