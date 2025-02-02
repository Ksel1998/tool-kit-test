<?php

use App\Http\Controllers\AdminUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Регистрация, вход и выход
Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
});

// Роуты для администратора
Route::middleware([
    JwtMiddleware::class,
    AdminMiddleware::class
])->prefix('admin')->group(function () {
    // Управление пользователями
    Route::get('/get_all_users', [AdminUserController::class, 'getAllUsers']);
    Route::patch('/update_user/{userId}', [AdminUserController::class, 'updateUser']);
    Route::delete('/delete_user/{userId}', [AdminUserController::class, 'deleteUser']);
});