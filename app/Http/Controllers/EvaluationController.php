<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $evaluations = Evaluation::with('enrollment.user', 'enrollment.course')->paginate(10);
            return response()->json($evaluations);
        } catch (\Exception $e) {
            return response()->json(['error' => 'falló al obtener las evaluaciones: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            $evaluation = Evaluation::create([
                'enrollment_id' => $validatedData['enrollment_id'],
                'score' => $validatedData['score'],
                'feedback' => $validatedData['feedback'],
                'evaluated_at' => now()->format('Y-m-d H:i:s'),
            ]); 
            return response()->json([
                'evaluation' => $evaluation->only(['id', 'enrollment_id', 'score', 'feedback', 'evaluated_at']),
                'message' => 'Evaluación creada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'falló al crear la evaluación: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $evaluation = Evaluation::with('enrollment.user', 'enrollment.course')->select('id', 'enrollment_id', 'score', 'feedback', 'evaluated_at')->findOrFail($id);
            return response()->json($evaluation);
        } catch (\Exception $e) {
            return response()->json(['error' => 'falló al obtener la evaluación: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, int $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvaluationRequest $request, int $id)
    {
        try {
            $validateData = $request->validated();

            $evaluation = Evaluation::findOrFail($id);
            $evaluation->enrollment_id = $validateData['enrollment_id'];
            $evaluation->score = $validateData['score'];
            $evaluation->feedback = $validateData['feedback'];
            $evaluation->evaluated_at = now()->format('Y-m-d H:i:s'); // Actualizar la fecha de evaluación
            $evaluation->save();

            return response()->json([
                'message' => 'Evaluación actualizada exitosamente',
                'evaluation' => $evaluation,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'falló al obtener la evaluación: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $evaluation = Evaluation::findOrFail($id);
            $evaluation->delete();
            return response()->json(['message' => 'Evaluación eliminada exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'falló al eliminar la evaluación: ' . $e->getMessage()], 500);
        }
    }
}
