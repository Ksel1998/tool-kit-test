<?php

namespace App\Http\Middleware;

use App\Models\UserRoles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userRole = UserRoles::where('id', $user->role_id)->first();
        
        if ($userRole->name !== 'admin')
        {
            return response()->json(['error' => 'Не хватает прав для действий'], 403);
        }

        return $next($request);
    }
}
