<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Add HasRoles trait

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relation with Role (single role)
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation with Customers (agent assigned)
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'agent_id');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Get role name safely
     */
    public function getRoleName()
    {
        return $this->role ? $this->role->name : 'No Role';
    }

    /**
     * Query scope to filter users by role
     */
    public function scopeRole($query, $roleName)
    {
        return $query->whereHas('role', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
