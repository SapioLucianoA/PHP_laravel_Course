<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
{
    if (!$request->user()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    
    if ($request->user()->role !== 'admin') {
        return response()->json([
            'message' => 'Forbidden - Admin access required'
        ], 403);
    }

    return $next($request);
}
}
