<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoeCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'brand',
        'description',
    ];
}
