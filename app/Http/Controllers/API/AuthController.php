<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('AccessToken')->plainTextToken;
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => collect($user)->only(['id', 'name', 'email']),
            'message' => 'Login successful'
        ]);
    }
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'message' => 'User profile retrieved successfully',
            'success' => true
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
            'success' => true
        ], 200);
    }
}
