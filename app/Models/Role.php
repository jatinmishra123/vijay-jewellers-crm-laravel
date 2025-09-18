<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'permissions'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getPermissionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = json_encode($value);
    }
}