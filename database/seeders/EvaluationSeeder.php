<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Enrollment;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todas las inscripciones
        $enrollments = Enrollment::all();

        // Verificar que existen inscripciones
        if ($enrollments->isEmpty()) {
            $this->command->error('Error: Primero debes ejecutar EnrollmentsTableSeeder!');
            return;
        }

        // Crear evaluaciones realistas
        foreach ($enrollments as $enrollment) {
            // Fecha de evaluación (después de la inscripción)
            $evaluatedAt = Carbon::parse($enrollment->enrolled_at)
                              ->addDays(rand(7, 30)); // Entre 1 semana y 1 mes después

            // 80% de probabilidad de estar aprobado
            $isApproved = rand(1, 100) <= 80;
            $score = $isApproved ? rand(6, 10) : rand(1, 5);
            $feedback = $isApproved ? 'Aprobado. Buen trabajo!' : 'Desaprobado. Debes mejorar.';

            Evaluation::create([
                'enrollment_id' => $enrollment->id,
                'score' => $score,
                'feedback' => $feedback,
                'evaluated_at' => $evaluatedAt
            ]);
        }

        $this->command->info("¡Evaluaciones creadas exitosamente! ({$enrollments->count()} evaluaciones generadas)");
    }
}
