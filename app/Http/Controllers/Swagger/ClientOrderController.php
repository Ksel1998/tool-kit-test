<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

/**
 *  @OA\Get(
 *      path="/api/client/get_orders/{orderId}",
 *      summary="Получение заявок текущего пользователя",
 *      description="Если есть orderId - вернет конкретную заявку. Если нет - вернет все заявки",
 *      tags={"Client"},
 *      @OA\Parameter(
 *          name="orderId",
 *          in="path",
 *          required=false,
 *          description="ID заявки (необязательный параметр)",
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
 *          description="Успешное получение заявок",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="orders", type="array",
 *                          @OA\Items(
 *                              type="object",
 *                              @OA\Property(property="id", type="integer", example=1),
 *                              @OA\Property(property="order", type="string", example="Animi veniam aliquid vel quia quam at."),
 *                              @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина 4б"),
 *                              @OA\Property(property="phone", type="string", example="88005553535"),
 *                              @OA\Property(property="user_id", type="integer", example=3),
 *                              @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                              @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                              @OA\Property(property="get_files", type="array",
 *                                  @OA\Items(
 *                                      @OA\Property(property="id", type="integer", example=84),
 *                                      @OA\Property(property="item_name", type="string", example="test.jpg"),
 *                                      @OA\Property(property="path", type="string", example="/storage/app/public/test.jpg"),
 *                                      @OA\Property(property="orders_id", type="integer", example=1),
 *                                      @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                                      @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
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
 *          response=403,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      ),
 *      
 *      @oA\Response(
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
 *      path="/api/client/add_order",
 *      summary="Создание новой заявки",
 *      tags={"Client"},
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
 *          description="Успешное создание заявки",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Заявка успешно создана"),
 *                      @OA\Property(property="newData", type="object",
 *                          @OA\Property(property="order", type="string", example="Animi veniam aliquid vel quia quam at."),
 *                          @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина 4б"),
 *                          @OA\Property(property="phone", type="string", example="88005553535"),
 *                          @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                          @OA\Property(property="files", type="array",
 *                              @OA\Items(
 *                                  @OA\Property(property="id", type="integer", example=84),
 *                                  @OA\Property(property="item_name", type="string", example="test.jpg"),
 *                                  @OA\Property(property="path", type="string", example="/storage/app/public/test.jpg"),
 *                                  @OA\Property(property="orders_id", type="integer", example=1),
 *                                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                              )
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
 *          response=403,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      ),
 *      
 *      @oA\Response(
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
 *      path="/api/client/update_order/{orderId}",
 *      summary="Обновление заявки",
 *      tags={"Client"},
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
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Обновление прошло успешно"),
 *                      @OA\Property(property="newData", type="object",
 *                          @OA\Property(property="order", type="string", example="Animi veniam aliquid vel quia quam at."),
 *                          @OA\Property(property="address", type="string", example="г. Москва, ул. Пушкина 4б"),
 *                          @OA\Property(property="phone", type="string", example="88005553535"),
 *                          @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                          @OA\Property(property="files", type="array",
 *                              @OA\Items(
 *                                  @OA\Property(property="id", type="integer", example=84),
 *                                  @OA\Property(property="item_name", type="string", example="test.jpg"),
 *                                  @OA\Property(property="path", type="string", example="/storage/app/public/test.jpg"),
 *                                  @OA\Property(property="orders_id", type="integer", example=1),
 *                                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-03T05:34:02.000000Z"),
 *                              )
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
 *          response=403,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      ),
 *      
 *      @oA\Response(
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
 *  @OA\Delete(
 *      path="/api/client/delete_order/{orderId}",
 *      summary="Удаление заявки пользователем",
 *      tags={"Client"},
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
 *                      type="object",
 *                      @OA\Property(property="status", type="string", example="Заявка не найдена")
 *                  )
 *              }
 *          )
 *      ),
 * 
 *      @OA\Response(
 *          response=403,
 *          description="Нехватка прав для действий",
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      @OA\Property(property="error", type="string", example="Не хватает прав для действий")
 *                  )
 *              }
 *          )
 *      ),
 *      
 *      @oA\Response(
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

class ClientOrderController extends Controller
{

}
