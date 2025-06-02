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
        try{
            $courses = Course::Select('id','name','desription', 'created_by');
        }catch (\Exception $e) {
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
}

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
