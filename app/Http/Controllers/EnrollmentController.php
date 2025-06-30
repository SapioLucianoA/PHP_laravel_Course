<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $enrollments = enrollment::with('user', 'course')
                ->orderBy('enrolled_at', 'desc')
                ->paginate(10);
            return response()->json($enrollments, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener las inscripciones',
                'message' => $e->getMessage()
            ], 500);
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
    public function store(StoreEnrollmentRequest $request)
    {
        try {
            
            $validatedData = $request->validated();

            $user = Auth::user();

            
            // Validar si ya existe una inscripción
            $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                ->where('course_id', $validatedData['course_id'])
                ->exists();

            if ($alreadyEnrolled) {
                return response()->json([
                    'message' => 'El usuario ya está inscrito en este curso',
                ], 422);
            }
            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $validatedData['course_id'],
                'enrolled_at' => now()->format('Y-m-d H:i:s'),
            ]);
            $enrollment->load('user', 'course');
            return response()->json([
                'message' => 'usted se a inscrito correctamente',
                'enrollment' => $enrollment->only(['id', 'enrolled_at', 'user', 'course']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $enrollment = Enrollment::with('user', 'course')
                ->findOrFail($id);

            return response()->json($enrollment, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'La adscripcion no fue encontrada',
                'error message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnrollmentRequest $request, int $id)
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            $validatedData = $request->validated();
            
            $enrollment->user_id = $validatedData['user_id'];
            $enrollment->course_id = $validatedData['course_id'];
            $enrollment->save();
            $enrollment->load('user', 'course');
            return response()->json([
                'message' => 'Inscripción actualizada correctamente',
                'enrollment' => $enrollment->only(['id', 'enrolled_at' , 'user', 'course']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar la inscripción',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();
            return response()->json([
                'message' => 'te has dado de baja exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al darse de baja',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
