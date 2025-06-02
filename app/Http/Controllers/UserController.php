<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
{
    $users = User::select('id', 'name', 'email')->get();

    if ($users->isEmpty()) {
        return response()->json([
            'message' => 'No hay usuarios encontrados',
            'status' => 404
        ], 404);
    }

    return response()->json([
        'users' => $users,
        'message' => 'Lista de Usuarios',
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
        'name' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|max:16',
    ]);

    $validatedData['password'] = bcrypt($validatedData['password']);
    $user = User::create($validatedData);

    return response()->json([
        'message' => 'Usuario creado',
        'user' => $user->only(['id', 'name', 'lastName', 'email']),
    ], 201);
}

  /**
   * Display the specified resource.
   */
  public function show($id)
{
    $user = User::select('id', 'name', 'email')->find($id);
    
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
}

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user) {}
}
