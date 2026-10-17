<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use SoftDeletes;
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


    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customers_id');
    }

    // Relasi ke tabel order_details
    public function items(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
