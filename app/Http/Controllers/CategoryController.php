<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::select('id', 'name', 'description')
            ->orderBy('name', 'asc')
            ->get();
            if ($categories->isEmpty()) {
                return response()->json([
                    'status' => 'error 404',
                    'message' => 'no se encontraron categorias'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $categories,
                'message' => 'Categorias enviadas'
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'error al enviar categorias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function coursesPorCategory(int $id)
    {
        try{
            $category = Category::findOrFail($id);
            $courses = $category->courses()->select('id','name','description')->get();
            return response()->json([
                'status' => 'success',
                'data' => $courses,
                'message' => 'Cursos enviados por categoria: '.$category->name
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'error al enviar cursos por categoria: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $category = Category::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $category ->only(['id', 'name', 'description']),
                'message' => 'Categoria creada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found: ' . $e->getMessage()
            ], 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        try {
            $validateData = $request->validated();
            $category = Category::findOrFail($id);
            $category->name = $validateData['name'];
            $category->description = $validateData['description'];
            $category->save();
            return response()->json([
                'message' => 'Categoria actualizada exitosamente',
                'category' => $category->only(['id', 'name', 'description']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la categoria',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message' => 'Categoria eliminada exitosamente',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la categoria',
                'status' => 500
            ], 500);
        }
    }

}
