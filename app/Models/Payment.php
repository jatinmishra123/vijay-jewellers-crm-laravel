<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Fillable fields as per your table
    protected $fillable = [
        'scheme_id',
        'customer_id',
        'amount',
        'payment_duration',
        'status',
        'method',
        'notes',
        'due_date',
        'paid_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}
