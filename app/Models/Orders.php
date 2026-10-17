<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customers_id',
        'total_price',
        'payment_status',
        'payment_method',
        'entry_date',
        'estimated_completion_date',
    ];

    // Relasi ke tabel order_details
    public function items(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
