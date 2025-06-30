<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::create([
            'name' => 'Programación',
            'description' => 'Cursos sobre desarrollo de software y programación',
        ]);
        Category::create([
            'name' => 'Diseño Gráfico',
            'description' => 'Aprende diseño visual, UX/UI y herramientas creativas'
        ]);
        Category::create([
            'name' => 'Marketing Digital',
            'description' => 'Estrategias de marketing online y redes sociales'
        ]);
        Category::create([
            'name' => 'Idiomas',
            'description' => 'Cursos de idiomas para todos los niveles'
        ]);
        Category::create([
            'name' => 'Ciencias Exactas',
            'description' => 'Matemáticas, física y otras ciencias exactas'
        ]);
        Category::create([
            'name' => 'Humanidades',
            'description' => 'Historia, filosofía y ciencias sociales'
        ]);
        Category::create([
            'name' => 'Negocios',
            'description' => 'Administración, emprendimiento y finanzas'
        ]);
        Category::create([
            'name' => 'Desarrollo Personal',
            'description' => 'Crecimiento profesional y habilidades blandas'
        ]);

    }
}
