<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'last_name', 'email', 'role')
                ->where('role', '!=', 'admin') // Excluir administradores
                ->get();

            if ($users->isEmpty()) {
                return response()->json(['message' => 'No se encontraron usuarios'], 404);
            }
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Los ususario no fueron encontrados :c'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|max:16',
            ]);

            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'role' => 'admin',
            ]);

            return response()->json([
                'message' => 'Usuario creado',
                'user' => $user->only(['id', 'name', 'last_name', 'email', 'role']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el usuario'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|max:16',
            ]);

            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create([
                'name' => $validatedData['name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'role' => 'student',
            ]);

            return response()->json([
                'message' => 'Usuario creado',
                'user' => $user->only(['id', 'name', 'last_name', 'email']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el usuario'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $user = User::select('id', 'name', 'last_name', 'email', 'is_admin')->find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no encontrado',
                    'status' => 404
                ], 404);
            }

            return response()->json([
                'user' => $user,
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el usuario',
                'status' => 500
            ], 500);
        }
    }

    /** 
     * Muestra todas las adscripciones de un ususario con su curso asociado (nombre e id)
     */
    public function showUserCourses(int $id)
    {
        try {
            $user = User::with([
                'enrollments.course'
            ])->findOrFail($id);
            return response()->json([
                'enrollments' => $user->enrollments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las adscripciones del usuario',
                'status' => 500
            ], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function showUserEvaluations(int $id)
    {
        try {
            $user = User::with([
                'enrollments.evaluations'
            ])->findOrFail($id);

            $evaluations = $user->enrollments
                ->flatMap(function ($enrollment) {
                    return $enrollment->evaluations->map(function ($evaluation) use ($enrollment) {
                        return [
                            'id' => $evaluation->id,
                            'score' => $evaluation->score,
                            'feedback' => $evaluation->feedback,
                            'evaluated_at' => $evaluation->evaluated_at,
                            'course' => [
                                'id' => $enrollment->course->id ?? null,
                                'title' => $enrollment->course->title ?? null,
                            ],
                        ];
                    });
                });
            return response()->json([
                'evaluations' => $evaluations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las evaluaciones del usuario',
                'status' => 500
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);
            $User = User::findOrFail($id);
            $User->name = $validateData['name'];
            $User->last_name = $validateData['last_name'];
            $User->email = $validateData['email'];
            $User->save();

            return response()->json([
                'message' => 'Usuario actualizado',
                'user' => $User->only(['name', 'last_name', 'email']),

                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el usuario'], 500);
        }
    }
}
