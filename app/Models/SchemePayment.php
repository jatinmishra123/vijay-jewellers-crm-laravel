<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheme_id',          // किस scheme से जुड़ा है
        'customer_id',        // किस customer ने payment किया
        'payment_duration',   // जैसे "30 days", "6 months"
        'amount',             // कितना amount pay हुआ
        'status',             // pending / success / failed
        'method',             // cash / upi / card etc
        'notes',              // optional remarks
        'due_date',           // कब तक payment करना था
        'paid_at',            // कब actual payment हुआ
    ];

    // Relations
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
