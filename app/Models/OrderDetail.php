<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'services_id',
        'brand',
        'color',
        'price',
        'status',
        'notes',
    ];
}
