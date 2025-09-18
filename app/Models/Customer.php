<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    // ✅ Fillable fields matching your DB table
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'scheme_id',
        'is_active',
        'verification_status',
        'agent_id',
        'token',
        'scheme_duration',
        'scheme_total_amount',
        'mtoken',
        'qr_code',
        'payment_status',    // New field
        'payment_link',      // New field
    ];

    // ✅ Casting
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Verification status constants
    const VERIFICATION_PENDING = 'pending';
    const VERIFICATION_APPROVED = 'approved';
    const VERIFICATION_REJECTED = 'rejected';

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_SUCCESS = 'success';
    const PAYMENT_FAILED = 'failed';

    // ✅ Relation with agent
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id', 'id');
    }


    // ✅ Relation with sales
    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }

    // ✅ Relation with coupon
    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'customer_id');
    }

    // ✅ Scope for active customers
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('verification_status', self::VERIFICATION_APPROVED);
    }

    // ✅ Scope for pending verification
    public function scopePendingVerification($query)
    {
        return $query->where('verification_status', self::VERIFICATION_PENDING);
    }

    // ✅ Scope for inactive or rejected customers
    public function scopeInactive($query)
    {
        return $query->where('is_active', false)
            ->orWhere('verification_status', self::VERIFICATION_REJECTED);
    }

    // ✅ Get today's new customers
    public static function getTodaysNewCustomers()
    {
        return self::whereDate('created_at', today())->count();
    }

    // ✅ Get active members count
    public static function getActiveMembersCount()
    {
        return self::active()->count();
    }

    // ✅ Get inactive or pending verification count
    public static function getInactivePendingCount()
    {
        return self::where(function ($query) {
            $query->where('is_active', false)
                ->orWhere('verification_status', self::VERIFICATION_PENDING);
        })->count();
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }
    public function schemePayments()
    {
        return $this->hasMany(\App\Models\SchemePayment::class, 'customer_id');
    }

}
