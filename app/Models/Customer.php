<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    // ✅ Fillable fields (CRM + WP/Woo Sync support)
    protected $fillable = [
        'woo_id',
        'wp_id',
        'username',
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile',
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
        'payment_status',
        'payment_link',
        'role',
        'registered_date',
    ];

    // ✅ Casting
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'registered_date' => 'datetime',
    ];

    // Verification status constants
    const VERIFICATION_PENDING = 'pending';
    const VERIFICATION_APPROVED = 'approved';
    const VERIFICATION_REJECTED = 'rejected';

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_SUCCESS = 'success';
    const PAYMENT_FAILED = 'failed';

    /*
    |--------------------------------------------------------------------------
    | 🔹 Relations
    |--------------------------------------------------------------------------
    */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }

    public function schemePayments()
    {
        return $this->hasMany(\App\Models\SchemePayment::class, 'customer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('verification_status', self::VERIFICATION_APPROVED);
    }

    public function scopePendingVerification($query)
    {
        return $query->where('verification_status', self::VERIFICATION_PENDING);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false)
            ->orWhere('verification_status', self::VERIFICATION_REJECTED);
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 Stats Helpers
    |--------------------------------------------------------------------------
    */
    public static function getTodaysNewCustomers()
    {
        return self::whereDate('created_at', today())->count();
    }

    public static function getActiveMembersCount()
    {
        return self::active()->count();
    }

    public static function getInactivePendingCount()
    {
        return self::where(function ($query) {
            $query->where('is_active', false)
                ->orWhere('verification_status', self::VERIFICATION_PENDING);
        })->count();
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 Auto-generate QR Code when customer is created or updated
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::created(function ($customer) {
            $customer->generateQrCode();
        });

        static::updated(function ($customer) {
            if (empty($customer->qr_code)) {
                $customer->generateQrCode();
            }
        });
    }

    public function generateQrCode()
    {
        $qrData = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email ?? 'Not Provided',
            'token' => $this->token ?? '',
            'scheme' => $this->scheme?->name ?? null,
            'mtoken' => $this->mtoken ?? '',
            'use' => 'Verification / Check-in / Order Reference',
            'payment_status' => $this->payment_status,
            'payment_link' => $this->payment_link,
        ];

        $qrUrl = "https://quickchart.io/qr?text=" . urlencode(json_encode($qrData)) . "&size=200";

        $this->qr_code = $qrUrl;
        $this->saveQuietly(); // 👈 save without firing events again
    }
    // inside class Customer extends Model
    public function conversations()
    {
        return $this->hasMany(\App\Models\CustomerConversation::class, 'customer_id')->orderBy('created_at', 'desc');
    }

}
