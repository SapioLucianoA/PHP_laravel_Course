<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'id' => $course->category->id ?? null,
            'name' => $course->category->name ?? null,
        ],
        'creator' => [
            'id' => $course->creator->id ?? null,
            'name' => $course->creator->name ?? null,
            'last_name' => $course->creator->last_name ?? null,
            'email' => $course->creator->email ?? null,
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
    public function store(StoreCourseRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $adminUser = Auth::user();

            $course = Course::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'created_by' => $adminUser->id,
                'category_id' => $validatedData['category_id'],
            ]);
            $course->load('category', 'creator');
            return response()->json([
                'message' => 'Curso creado exitosamente',
                'course' => $course,
                'user' => $adminUser
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el curso',
                'message' => $e->getMessage(),
                'user' => $adminUser
                
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
    public function update(UpdateCourseRequest $request, int $id)
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
