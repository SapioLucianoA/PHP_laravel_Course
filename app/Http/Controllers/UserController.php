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
      'last_name' => 'required|string|max:255',
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
    try {
      $user = User::select('id', 'name', 'last_name','email')->find($id);

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
  public function update(Request $request, $id)
  {
    try{
      $validateData = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
      ]);
      // Toma un ID y devuelve un único modelo. Si no existe ningún modelo coincidente, se produce un error
      //a diferencia de find() que devuelve null si no encuentra el modelo
      $User = User::findOrFail($id);
      $User->name = $validateData['name'] ?? $User->name;
      $User->last_name = $validateData['last_name'] ?? $User->last_name;
      $User->email = $validateData['email'] ?? $User->email;

      //save() guarda el modelo en la base de datos
      $User->save();
      
      return response()->json([
        'message' => 'Usuario actualizado',
        'user' => $User->only(['name', 'last_name', 'email']), 
        // 'user' retorna los campos deseados, no se suele usar solo en casos especificos si es que
        //el front necesita los datos para mostrar al usaurio
        //depende del nivel de comunicacion que quiera tener la app con el usuario 
        //dejar como modo de prueba por ahora
        'status' => 200
      ]);
    }catch (\Exception $e) {
      return response()->json([
        'message' => 'Error al actualizar el usuario',
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
