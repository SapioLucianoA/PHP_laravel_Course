<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    //enrollment con (with) user (user_id)[laravel entiende la relacion a traves del modelo] y course (course_id)
    {
        $enrollments = Enrollment::with([
            'user:id,name,last_name, email',
            'course:id,title'
        ])->get();
        if ($enrollments->isEmpty()) {
            return response()->json([
                'message' => 'No hay inscripciones a mostrar',
                'status' => 500
            ], 500);
        }
        return response()->json([
            'enrollments' => $enrollments,
            'status' => 200
        ]);
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
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = Enrollment::create([
            'user_id' => $validatedData['user_id'],
            'course_id' => $validatedData['course_id'],
            'enrollent_at' => now(),
        ]);

        return response()->json([
            'message' => 'Inscripción creada exitosamente',
            'enrollment' => $enrollment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $enrollment = Enrollment::with([
                'user:id,name,email',
                'course:id,enrollent_at'
            ])->find($id);
            if (!$enrollment) {
                return response()->json([
                    'Message' => 'El usuario no está inscrito en el curso',
                    'status' => 404
                ], 404);
            }
            return response()->json([
                'enrollment' => $enrollment,
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Message' => 'Error al obtener la inscripción',
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
