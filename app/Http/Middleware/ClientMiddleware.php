<?php

namespace App\Http\Middleware;

use App\Models\Orders;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UserRoles;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userRole = UserRoles::find($user->role_id);
        
        if ($request->orderId)
        {
            $order = Orders::find($request->orderId);
            
            if ($order->user_id !== $user->id && $userRole->name !== 'admin')
            {
                return response()->json(['error' => 'Не хватает прав для действий'], 401);
            }
        }

        return $next($request);
    }
}
