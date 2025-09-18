<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'scheme_id',
        'scheme_payment_id',
        'coupon_code',
        'lucky_draw_amount',
        'status',
        'reward_type',
        'reward_value',
        'reward_message',
        'reward_status',
        'rewarded_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function schemePayment()
    {
        return $this->belongsTo(SchemePayment::class);
    }
}
