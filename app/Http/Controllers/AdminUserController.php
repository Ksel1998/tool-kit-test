<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminUserController extends Controller
{
    // Получить список всех пользователей
    public function getAllUsers()
    {
        $allUsers = User::get();
        
        return response()->json([
            'allUsers' => $allUsers
        ], 200);
    }

    // Обновить данные пользователя
    public function updateUser(Request $request)
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

        User::find($request->userId)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        $updatedUser = User::find($request->userId);

        return response()->json([
            'status' => 'Обновление прошло успешно',
            'newData' => $updatedUser
        ], 200);
    }

    // Удалить пользователя
    public function deleteUser(Request $request)
    {
        $user = User::find($request->userId);

        if (!$user)
        {
            return response()->json([
                'status' => 'Пользователь не найден'
            ], 204);
        }

        $orders = Orders::where('user_id', $user->id)->with(['getFiles'])->get();

        foreach ($orders as $order)
        {
            foreach ($order->getFiles as $file)
            {
                $path = storage_path('app/public/' . $file->path);

                if (File::exists($path))
                {
                    File::delete($path);
                }
            }
        }

        $userName = $user->name;
        
        $user->delete();

        return response()->json([
            'status' => 'Пользователь: ' . $userName . ' успешно удален(a)',
        ], 200);
    }
}
