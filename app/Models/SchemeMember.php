<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeMember extends Model
{
    protected $table = 'scheme_members';

    protected $fillable = [
        'scheme_id',
        'customer_id',
        'joined_date',
        'payment_status'
    ];

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}