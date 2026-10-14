<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoeCategory extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'description',
    ];
}
