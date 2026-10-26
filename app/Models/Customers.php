<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Customers extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    public function branches() : BelongsTo
    {
        return $this->belongsTo(Branches::class,'branch_id');

    }
}
