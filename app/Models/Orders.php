<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_id',
        'total_price',
        'payment_status',
        'payment_method',
        'entry_date',
        'estimated_completion_date',
    ];
}
