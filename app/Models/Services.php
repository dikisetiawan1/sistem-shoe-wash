<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'estimated_days',
    ];
}
