<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFiles extends Model
{
    protected $table = 'order_files';

    protected $fillable = [
        'item_name',
        'path',
        'orders_id'
    ];
}
