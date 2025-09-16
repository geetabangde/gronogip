<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'image',
        'quantity',
        'price',
        'description',
        'brand_id',
        'user_id',
        'status',
        
    ];

    // Relationship: Product belongs to Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Optional: Product belongs to User (owner)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
