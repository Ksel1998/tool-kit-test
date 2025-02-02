<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    use HasFactory;

    protected $fillable = [
        'order',
        'address',
        'phone',
        'user_id'
    ];

    // Взять все файлы заявки
    public function getFiles()
    {
        return $this->hasMany(OrderFiles::class, 'orders_id', 'id');
    }
}
