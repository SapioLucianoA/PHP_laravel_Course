<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener IDs necesarios
        $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
        $categoryIds = \App\Models\Category::pluck('id')->toArray();

        // Verificar que existen admins y categorías
        if (empty($adminIds) || empty($categoryIds)) {
            $this->command->error('Error: Primero debes ejecutar UsersTableSeeder y CategoriesTableSeeder!');
            return;
        }

        // Cursos de ejemplo con datos realistas
        $courses = [
            [
                'title' => 'Laravel desde Cero',
                'description' => 'Domina el framework PHP más popular',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'Diseño UX/UI Avanzado',
                'description' => 'Principios profesionales de diseño de interfaces',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'Marketing Digital 2023',
                'description' => 'Estrategias actualizadas para redes sociales',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'Inglés Técnico para IT',
                'description' => 'Vocabulario esencial para desarrolladores',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'Matemáticas para Data Science',
                'description' => 'Fundamentos matemáticos aplicados',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'Historia Argentina Contemporánea',
                'description' => 'Siglo XX y actualidad',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'React JS Moderno',
                'description' => 'Desarrollo frontend con React',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ],
            [
                'title' => 'Python para Principiantes',
                'description' => 'Introducción a la programación con Python',
                'created_by' => $adminIds[array_rand($adminIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ]
        ];

        // Insertar cursos
        foreach ($courses as $course) {
            Course::create($course);
        }

        $this->command->info('¡Cursos creados exitosamente!');
    }
}
