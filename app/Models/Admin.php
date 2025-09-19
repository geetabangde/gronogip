<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin'; // ✅ Ensure admin guard is defined

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ✅ Password hashing automatically
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Admin role name attribute for display purposes
    public function getRoleNameAttribute()
    {
        $roles = [
            1 => 'Admin',
            2 => 'Retailer',
            3 => 'Manufacturer',
        ];

        return $roles[$this->role_id] ?? 'Unknown';
    }
    public function brands()
   {
      return $this->hasMany(Brand::class, 'manufacturer_id', 'id');
   }

}
