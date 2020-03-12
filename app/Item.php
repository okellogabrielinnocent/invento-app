<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //let capture all values
    protected $fillable = [
        'cost',
        'size',
        'quantity',
        'minimum_quantity',
        'brand',
        'code',
        'saleable',
        'name'
    ];
}
