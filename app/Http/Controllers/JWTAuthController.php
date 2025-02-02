<?php

namespace App\Http\Controllers;

use App\Models\UserRoles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JWTAuthController extends Controller
{
    // Регистрация
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $clientId = UserRoles::where('name', 'client')->value('id');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $clientId,
            'remember_token' => Str::random(60)
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    // Вход в акаунт
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try 
        {
            if (!$token = JWTAuth::attempt($credentials))
            {
                return response()->json(['error' => 'Неправильные данные'], 401);
            }

            $user = Auth::user();

            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'Не получилось создать токен'], 500);
        }
    }

    // Получить текущего пользователя
    public function getUser()
    {
        try
        {
            
            if (!$user = JWTAuth::parseToken()->authenticate())
            {
                return response()->json(['error' => 'Пользователь не найден'], 404);
            }
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'Неправильный токен'], 400);
        }

        return response()->json(compact('user'));
    }

    // Выход из акаунта
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Успешный выход из акаунта']);
    }
}
