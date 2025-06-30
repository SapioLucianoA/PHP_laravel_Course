<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courses = Course::with(['category', 'creator'])->paginate(10);
            $filtered = $courses->map(function ($course) {
    return [
        'id' => $course->id,
        'title' => $course->title,
        'description' => $course->description,
        'category' => [
            'id' => $course->category->id,
            'name' => $course->category->name,
        ],
        'creator' => [
            'id' => $course->creator->id,
            'name' => $course->creator->name,
            'last_name' => $course->creator->last_name,
            'email' => $course->creator->email,
        ],
    ];
});
            return response()->json([
                'status' => 'success',
                'data' => $filtered
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los cursos',
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
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'created_by' => 'required|exists:users,id',
                'category_id' => 'required|exists:categories,id',
            ]);
            $user = User::find($validatedData['created_by']);

            if (!$user || $user->role !== 'admin') {
                return response()->json(['error' => 'Solo los administradores pueden crear cursos'], 403);
            }

            $course = Course::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'created_by' => $validatedData['created_by'],
                'category_id' => $validatedData['category_id'],
            ]);
            $course->load('category', 'creator');
            return response()->json([
                'message' => 'Curso creado exitosamente',
                'course' => $course
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $course = Course::with(['category', 'creator'])->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $course
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Curso no encontrado',
                'message' => $e->getMessage()
            ], 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $course = Course::findOrFail($id);
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'category_id' => 'required|exists:categories,id',
                'created_by' => 'required|exists:users,id',
            ]);

            $course->title = $validatedData['title'];
            $course->description = $validatedData['description'];
            $course->category_id = $validatedData['category_id'];
            $course->created_by = $validatedData['created_by'];
            $course->save();

            $course->load('category', 'creator');
            return response()->json([
                'message' => 'Curso actualizado exitosamente',
                'course' => $course
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el curso',
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
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json([
                'message' => 'Curso eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
