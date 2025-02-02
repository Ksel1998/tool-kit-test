<?php

namespace App\Http\Controllers;

use App\Models\OrderFiles;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminOrderController extends Controller
{
    // Взять все заявки или заявки конкретного пользователя
    public function getOrders(Request $request)
    {
        if ($request->userId)
        {
            $orders = Orders::where('user_id', $request->userId)->with(['getFiles'])->get();
        }
        else
        {
            $orders = Orders::with(['getFiles'])->get();
        }

        return response()->json([
            'orders' => $orders
        ], 200);
    }

    // Обновить заявку
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'files.*' => 'file|mimes:jpg,png,pdf|max:6048'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }

        Orders::find($request->orderId)
            ->update([
                'order' => $request->order,
                'address' => $request->address,
                'phone' => $request->phone
            ]);

        if ($request->hasFile('files'))
        {
            $oldFiles = OrderFiles::where('orders_id', $request->orderId)->get();

            // Удаляем старые файлы
            foreach ($oldFiles as $file)
            {
                $path = storage_path('app/public/' . $file->path);

                if (File::exists($path))
                {
                    File::delete($path);
                }
                
                $file->delete();
            }
            
            // Загружаем новые файлы
            foreach ($request->file('files') as $file)
            {
                $path = $file->store('userFiles', 'public');
                $fileName = explode('/', $path)[1];

                OrderFiles::create([
                    'item_name' => $fileName,
                    'path' => $path,
                    'orders_id' => $request->orderId
                ]);
            }
        }

        $updatedOrder = Orders::with(['getFiles'])->find($request->orderId);

        return response()->json([
            'status' => 'Обновление прошло успешно',
            'newData' => $updatedOrder
        ], 200);
    }

    // Удаление заявки
    public function deleteOrder(Request $request)
    {
        $order = Orders::find($request->orderId);

        if (!$order)
        {
            return response()->json([
                'status' => 'Заявка не найдена'
            ], 204);
        }

        $orderFiles = OrderFiles::where('orders_id', $order->id)->get();

        foreach ($orderFiles as $file)
        {
            $path = storage_path('app/public/' . $file->path);

            if (File::exists($path))
            {
                File::delete($path);
            }
        }

        $orderId = $order->id;
        $orderName = $order->order;

        $order->delete();

        return response()->json([
            'status' => 'Заявка под №' . $orderId . ': ' . $orderName . ' успешно удалена',
        ], 200);
    }
}
