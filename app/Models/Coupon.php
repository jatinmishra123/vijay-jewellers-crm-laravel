<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_code',
        'customer_id',
        'status',
        'redeemed_at'
    ];

    // Relation with customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_REDEEMED = 'redeemed';
    const STATUS_EXPIRED = 'expired';
}
