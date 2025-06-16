<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courses = Course::with([
                'category:id,name',
                'createdBy:id,name,last_name',
            ])->select('id', 'tittle', 'description');
            return response()->json([
                'courses' => $courses,
                'message' => 'Lista de Cursos',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching courses: ' . $e->getMessage(),
                'status' => 500
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
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id', //exist: modelo.id verifica si existe un ususario con ese id
        ]);

        // el created_by es el id del usuario que crea el curso
        //NOTA: cmabiar despues con el usuario auth!!!!!!!!!!!
        $course = Course::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'created_by' => $validatedData['user_id'],
        ]);

        return response()->json([
            'message' => 'Curso creado exitosamente',
            'course' => $course,
        ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear curso: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $course = Course::select('id', 'title', 'description')->find($id);
            if (!$course) {
                return response()->json([
                    'message' => 'Curso no encontrado',
                    'status' => 404
                ], 404);
            }
            return response()->json($course);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el curso',
                'status' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * obtener todos los usuarios inscriptos en un curso
     */
    public function gatAllStudents(int $id)
    {
        try{
            $course = Course::with('students:id,name,last_name,email')->find($id);
            if (!$course) {
                return response()->json([
                    'message' => 'Curso no encontrado',
                    'status' => 404
                ], 404);
            }
            return response()->json([
                'course' => $course->only('id', 'title'),
                'students'=> $course->students,
                'message' => 'Lista de estudiantes del curso',
                'status' => 200
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los estudiantes del curso: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try{
            $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'created_by'=> 'required|exists:users,id', //exist: modelo.id verifica si existe un ususario con ese id
            ]);
            $course = Course::find($id);
            if (!$course) {
                return response()->json([
                    'message' => 'Curso no encontrado',
                    'status' => 404
                ], 404);
            }
            $course->save([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'created_by' => $validatedData['created_by'],
            ]);
            return response()->json([
                'message' => 'Curso actualizado exitosamente',
                'course' => $course,
                'status' => 200
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el curso: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try{
            $course = Course::find($id);
            if (!$course) {
                return response()->json([
                    'message' => 'Curso no encontrado',
                    'status' => 404
                ], 404);
            }

            $course->delete();

            return response()->json([
                'message' => 'Curso eliminado exitosamente',
                'status' => 200
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el curso: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
