<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

/**
 *  @OA\Get(
 *      path="api/admin/get_all_users",
 *      summary="Получение данных всех пользователей",
 *      tags={"Admin"},
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
 *                      schema="GetAllUsersResponse",
 *                      type="object",
 *                      @OA\Property(property="allUsers", type="array",
 *                          @OA\Items(
 *                              type="object",
 *                              @OA\Property(property="id", type="integer", example=1),
 *                              @OA\Property(property="name", type="string", example="Takeshi Kitano"),
 *                              @OA\Property(property="email", type="string", format="email", example="takeshi@mail.com"),
 *                              @OA\Property(property="role_id", type="integer", example=2),
 *                              @OA\Property(property="created_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                              @OA\Property(property="updated_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                          )
 *                      )
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="AdminAuthError",
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      )
 *  ),
 * 
 *  @OA\Patch(
 *      path="/api/update_user/{user_id}",
 *      summary="Обновление данных пользователя",
 *      tags={"Admin"},
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
 *                      schema="UserUpdateRequest",
 *                      type="object",
 *                      required={"userId", "name", "email", "password", "password_confirmation"},
 *                      @OA\Property(property="userId", type="integer", example="5"),
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
 *          response=200,
 *          description="Успешное обновление пользователя",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="UserUpdateResponse",
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Обновление прошло успешно"),
 *                      @OA\Property(property="newData", type="object",
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
 *          response=400,
 *          description="Ошибка валидации",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="ValidationError",
 *                      type="object",
 *                      example={
 *                          "name" : {"The name field is required."},
 *                          "email": {"The email field is required."},
 *                          "password": {"The password must be at least 3 characters."},
 *                          "password_confirmation": {"The password field confirmation does not match."}
 *                      }
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="AdminAuthError",
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      )
 *  ),
 * 
 *  @OA\Delete(
 *      path="/api/admin/delete_user/{userId}",
 *      summary="Удаление пользователя",
 *      tags={"Admin"},
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
 *                      schema="UserUpdateRequest",
 *                      type="object",
 *                      required={"userId"},
 *                      @OA\Property(property="userId", type="integer", example="5"),
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Успешное удаление пользователя",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="UserUpdateResponse",
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Пользователь User Name успешно удален")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=204,
 *          description="Проблема с нахождением пользователя",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="UserUpdateResponse",
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Пользователь не найден")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="AdminAuthError",
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      )
 *  )
 */

class AdminUserController extends Controller
{
    
}
