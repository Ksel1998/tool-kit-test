<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

/**
 *  @OA\Info(
 *      title="tool-kit API", 
 *      version="1.0",
 *      description="Апи регистрации"
 *  ),
 *  @OA\Server(
 *      description="Основной API-сервер",
 *      url="http://127.0.0.1:8008"
 *  )
 *  @OA\Post(
 *      path="/api/register",
 *      summary="Регистрация нового пользователя",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      required={"name", "email", "password", "password_confirmation"},
 *                      @OA\Property(property="name", type="string", example="Takeshi Kitano"),
 *                      @OA\Property(property="email", type="string", format="email", example="takeshi@mail.com"),
 *                      @OA\Property(property="password", type="string", format="password", example="kiwami"),
 *                      @OA\Property(property="password_confirmation", type="string", format="password", example="kiwami")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=201,
 *          description="Пользователь успешно зарегистрирован",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="user", type="object",
 *                          @OA\Property(property="id", type="integer", example=1),
 *                          @OA\Property(property="name", type="string", example="Takeshi Kitano"),
 *                          @OA\Property(property="email", type="string", format="email", example="takeshi@mail.com"),
 *                          @OA\Property(property="role_id", type="integer", example=2),
 *                      ),
 *                      @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1...")
 *                  )
 *              }             
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=400,
 *          description="Ошибка валидации",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      example={"email": {"The email field is required."}, "password": {"The password must be at least 3 characters."}}
 *                  )
 *              }
 *          )
 *      )
 *  ),
 * 
 *  @OA\Post(
 *      path="/api/login",
 *      summary="Вход в акаунт пользователя",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      required={"email", "password"},
 *                      @OA\Property(property="email", type="string", format="email", example="takeshi@mail.com"),
 *                      @OA\Property(property="password", type="string", format="password", example="kiwami")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Пользователь успешно вошел в акаунт",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1...")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Неправильные данные",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Неправильные данные")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=500,
 *          description="Проблемы с токеном",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не получилось создать токен")
 *                  )
 *              }
 *          )
 *      )
 *  ),
 * 
 *  @OA\Get(
 *      path="/api/user",
 *      summary="Получение данных о текущем пользователе",
 *      tags={"Auth"},
 *      @OA\Parameter(
 *          name="Authorization",
 *          in="header",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1..."
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Успешное получение данных о пользователе",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="user", type="object",
 *                          @OA\Property(property="id", type="integer", example=1),
 *                          @OA\Property(property="name", type="string", example="Takeshi Kitano"),
 *                          @OA\Property(property="email", type="string", format="email", example="takeshi@mail.com"),
 *                          @OA\Property(property="role_id", type="integer", example=2),
 *                          @OA\Property(property="created_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                          @OA\Property(property="updated_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                      )
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=404,
 *          description="Пользователь не найден",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Пользователь не найден")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Неправильный токен",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Неправильный токен")
 *                  )
 *              }
 *          )
 *      )
 *  ),
 * 
 *  @OA\Post(
 *      path="/api/logout",
 *      summary="Выход из акаунта",
 *      tags={"Auth"},
 *      @OA\Parameter(
 *          name="Authorization",
 *          in="header",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1..."
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      required={"email", "password"},
 *                      @OA\Property(property="email", type="string", format="email", example="takeshi@mail.com"),
 *                      @OA\Property(property="password", type="string", format="password", example="kiwami")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Успешный выход из акаунта",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="message", type="string", example="Успешный выход из акаунта")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Неправильный токен",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Неправильный токен")
 *                  )
 *              }
 *          )
 *      )
 *  )
 */
class JWTAuthController extends Controller
{

}
