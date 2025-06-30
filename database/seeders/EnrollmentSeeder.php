<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todos los estudiantes y cursos
        $students = User::where('role', 'student')->get();
        $courses = \App\Models\Course::all();

        // Verificar que existen estudiantes y cursos
        if ($students->isEmpty() || $courses->isEmpty()) {
            $this->command->error('Error: Primero debes ejecutar UsersTableSeeder y CoursesTableSeeder!');
            return;
        }

        // Crear inscripciones realistas
        foreach ($students as $student) {
            // Cada estudiante se inscribe a 1-3 cursos aleatorios
            $randomCourses = $courses->random(rand(1, 3));
            
            foreach ($randomCourses as $course) {
                // Fecha de inscripción aleatoria en los últimos 30 días
                $enrolledAt = Carbon::now()->subDays(rand(0, 30));
                
                Enrollment::create([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'enrolled_at' => $enrolledAt
                ]);
            }
        }

        $this->command->info("¡Inscripciones creadas exitosamente! ({$students->count()} estudiantes inscritos en cursos)");
    }
    }
