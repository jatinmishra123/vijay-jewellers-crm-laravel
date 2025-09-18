<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'customer_id',
        'amount',
        'payment_mode',
        'status',
        'reference',
        'transaction_date',
        'notes'
    ];

    // Payment का customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relation to Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
