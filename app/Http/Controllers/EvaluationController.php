<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluations = Evaluation::select('id', 'score', 'feedback', '')->get();
        if ($evaluations->isEmpty()) {
            return response()->json([
                'message' => 'No hay evaluaciones a mostrar',
                'status' => 500
            ], 500);
        }

        return response()->json($evaluations);
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'score' => 'required|numeric|between:0,10',
            'feedback' => 'nullable|string|max:500',
            'enrollment_id' => 'required|exists:enrollments,id',
        ]);
        $evaluation = Evaluation::create([
            'score' => $validatedData['score'],
            'feedback' => $validatedData['feedback'] ?? null,
            'enrollment_id' => $validatedData['enrollment_id'],
            'evaluated_at' => now(),
        ]);
        return response()->json([
            'message' => 'Evaluación creada exitosamente',
            'evaluation' => $evaluation->only(['id', 'score', 'feedback', 'evaluated_at']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $evaluation = Evaluation::find($id);
            if (!$evaluation) {
                return response()->json([
                    'message' => 'Evaluación no encontrada',
                    'status' => 404
                ], 404);
            }

            return response()->json($evaluation);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la evaluación',
                'status' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        //
    }
}
