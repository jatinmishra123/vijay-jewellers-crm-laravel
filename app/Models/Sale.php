<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = [
        'product_type',
        'product_name',
        'amount',
        'sale_date',
        'sale_type',
        'payment_status',
        'quantity',
        'customer_id',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // ✅ Relation with Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
