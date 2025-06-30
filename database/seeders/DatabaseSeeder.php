<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\CoursesSeeder;
use Database\Seeders\EnrollmentSeeder;
use Database\Seeders\EvaluationSeeder;



class DatabaseSeeder extends Seeder
{

    
    /**
     * Seed the application's database.
     */
    public function run()
    {

        $this->call([
        UsersTableSeeder::class,
        CategoriesSeeder::class,
        CoursesSeeder::class,
        EnrollmentSeeder::class,
        EvaluationSeeder::class, 
    ]);
    }
}
