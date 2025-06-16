<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorias a mostrar ',
                'status' => 500
            ], 500);
        }
        return response()->json([
            'categories' => $categories,
            'message' => 'Lista de Categorias',
            'status' => 200
        ], 200);
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $category = Category::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);
        return response()->json([
            'message' => 'Categoria creada exitosamente',
            'category' => $category,
        ], 201);
    }

    /**
     * todos los cursos asociadops a una categoria
     */
    public function show(int $id)
    {
        try {
            $category = Category::with(['courses:id,title'])->findOrFail($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Categoria no encontrada',
                    'status' => 404
                ], 404);
            }

            return response()->json([
                'Category' => $category,
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la Categoria',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:500',
            ]);
            $category = Category::findOrFail($id);
            $category->name = $validateData['name'];
            $category->description = $validateData['description'];
            $category->save();
            return response()->json([
                'message' => 'Categoria actualizada exitosamente',
                'category' => $category,
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
        try{
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message' => 'Categoria eliminada exitosamente',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la categoria',
                'status' => 500
            ], 500);
        }
    }
}
