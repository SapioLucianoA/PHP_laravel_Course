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
    try{
      $users = User::select('id', 'name', 'last_name','email')->get();

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
    }catch(\Exception $e) {
      return response()->json([
        'message' => 'Error al obtener los usuarios',
        'status' => 500
      ], 500);
    }

  }

  /**
   * Show the form for creating a new resource.
   */
  public function createAdmin(Request $request)
  {
    try{
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
      'is_admin' => true,
    ]);

    return response()->json([
      'message' => 'Usuario creado',
      'user' => $user->only(['id', 'name', 'last_name', 'email', 'is_admin']),
    ], 201);
    }catch (\Exception $e) {
      return response()->json([
        'message' => 'Error al crear el usuario',
        'status' => 500
      ], 500);
    }
    
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
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
      'is_admin' => false,
    ]);

    return response()->json([
      'message' => 'Usuario creado',
      'user' => $user->only(['id', 'name', 'last_name', 'email']),
    ], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    try {
      $user = User::select('id', 'name', 'last_name','email','is_admin')->find($id);

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
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, int $id)
  {
    try{
      $validateData = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
      ]);
      $User = User::findOrFail($id);
      $User->name = $validateData['name'] ;
      $User->last_name = $validateData['last_name'] ;
      $User->email = $validateData['email'] ;
      $User->save();
      
      return response()->json([
        'message' => 'Usuario actualizado',
        'user' => $User->only(['name', 'last_name', 'email']), 

        'status' => 200
      ]);
    }catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage(),
        'status' => 500
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id) 
  {
    try {
        $user = User::findOrFail($id);
        //borramos con sofdeletes
        //OnlyTrashed()->find($id) encuentra los trasheados deah
        $user->delete(); 

        return response()->json([
            'message' => 'Usuario marcado como eliminado',
            'user' => $user,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al eliminar el usuario',
            'error' => $e->getMessage(),
        ], 500);
    }
  }
}
