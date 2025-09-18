<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product_type',
        'product_name',
        'amount',
        'sale_date',
        'sale_type'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'amount' => 'decimal:2'
    ];
}