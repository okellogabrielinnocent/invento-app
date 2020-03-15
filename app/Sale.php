<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'quantity',
        'customer_id',
        'item_id',
        'staff_id'
    ];
}
