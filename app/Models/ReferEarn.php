<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferEarn extends Model
{
    use HasFactory;

    protected $table = 'refer_earn';

    protected $fillable = [
        'user_id',
        'referred_user_id',
        'subcategory_id',
        'reward_points'
    ];

    // Relationship with the referring user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with the referred user
    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    // Relationship with subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
