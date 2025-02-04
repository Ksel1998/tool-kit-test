<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

/**
 *  @OA\Get(
 *      path="/api/admin/get_orders/{userId}",
 *      summary="Получение заявок пользователей",
 *      description="Если есть userId - вернет все заявки пользователя. Если нет, то вернет все заявки",
 *      tags={"Admin"},
 *      @OA\Parameter(
 *          name="userId",
 *          in="path",
 *          required=false,
 *          description="ID пользователя (необязательный параметр)",
 *          @OA\Schema(type="integer", example="5")
 *      ),
 *      @OA\Parameter(
 *          name="Authorization",
 *          in="header",
 *          required=true,
 *          @OA\Schema(
 *              schema="GetAdminOrdersRequest",
 *              type="string",
 *              example="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1..."
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Успешное получение заявок",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="GetAdminOrdersResponse",
 *                      type="object",
 *                      @OA\Property(property="orders", type="array",
 *                          @OA\Items(
 *                              type="object",
 *                              @OA\Property(property="id", type="integer", example=1),
 *                              @OA\Property(property="order", type="string", example="Animi veniam aliquid vel quia quam at."),
 *                              @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина 4б"),
 *                              @OA\Property(property="phone", type="string", example="88005553535"),
 *                              @OA\Property(property="user_id", type="integer", example=3),
 *                              @OA\Property(property="created_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                              @OA\Property(property="updated_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                              @OA\Property(property="get_files", type="array",
 *                                  @OA\Items(
 *                                      @OA\Property(property="id", type="integer", example=84),
 *                                      @OA\Property(property="item_name", type="string", example="test.jpg"),
 *                                      @OA\Property(property="path", type="string", example="/storage/app/public/test.jpg"),
 *                                      @OA\Property(property="orders_id", type="integer", example=1),
 *                                      @OA\Property(property="created_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                                      @OA\Property(property="updated_at", type="timestamp", example="2025-02-03T05:34:02.000000Z"),
 *                                  )
 *                              )
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
 *  @OA\Post(
 *      path="/api/admin/update_order/{orderId}",
 *      summary="Обновление заявки администратором",
 *      tags={"Admin"},
 *      @OA\Parameter(
 *          name="orderId",
 *          in="path",
 *          required=true,
 *          description="ID заявки для обновления",
 *          @OA\Schema(type="integer", example=5)
 *      ),
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
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  schema="UpdateAdminOrderRequest",
 *                  type="object",
 *                  required={"order", "address", "phone"},
 *                  @OA\Property(property="order", type="string", example="Animi veniam aliquid vel quia quam at."),
 *                  @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина 4б"),
 *                  @OA\Property(property="phone", type="string", example="88005553535"),
 *                  @OA\Property(property="files", type="string", example="Массив для загрузки файлов")
 *              )
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=200,
 *          description="Успешное обновление заявки",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="UpdateAdminOrderResponse",
 *                      type="object",
 *                      @OA\Property(property="order", type="string", example="Animi veniam aliquid vel quia quam at."),
 *                      @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина 4б"),
 *                      @OA\Property(property="phone", type="string", example="88005553535"),
 *                      @OA\Property(property="files", type="array",
 *                          @OA\Items(
 *                              @OA\Property(property="id", type="integer", example=84),
 *                              @OA\Property(property="item_name", type="string", example="test.jpg"),
 *                              @OA\Property(property="path", type="string", example="/storage/app/public/test.jpg"),
 *                              @OA\Property(property="orders_id", type="integer", example=1),
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
 *          response=400,
 *          description="Ошибка валидации",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="ValidationError",
 *                      type="object",
 *                      example={
 *                          "order" : {"The order field is required."},
 *                          "address": {"The address field is required."},
 *                          "phone": {"The phone field is required."}
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
 *      path="/api/admin/delete_order/{orderId}",
 *      summary="Обновление заявки администратором",
 *      tags={"Admin"},
 *      @OA\Parameter(
 *          name="orderId",
 *          in="path",
 *          required=true,
 *          description="ID заявки для удаления",
 *          @OA\Schema(type="integer", example=5)
 *      ),
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
 *          description="Успешное удаление заявки",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="OrderAdminDeleteResponse",
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Заявка успешно удалена")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=204,
 *          description="Проблема с нахождением заявки",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="OrderAdminDeleteResponse",
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Заявка не найдена")
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

class AdminOrderController extends Controller
{
    
}
