<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'total_amount',
        'status'
    ];

    public function members()
    {
        return $this->belongsToMany(Customer::class, 'scheme_members')
            ->withPivot('joined_date', 'payment_status')
            ->withTimestamps();
    }
}