<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\belongsTo;
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


    public function category()
    {
        return $this->belongsTo(ShoeCategory::class, 'shoe_categories_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'services_id');
    }
    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customers_id');
    }

    public function branch() : BelongsTo
    {
        return $this->belongsTo(Branches::class,'branch_id');

    }
}
