<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandListing extends Model
{
    use HasFactory;

    protected $table = 'demand_listings'; // If table name differs from default

    // Fillable fields for mass assignment
    protected $fillable = [
        'subcategory_id',
        'quantity',
        'selling_rate',
        'per_unit',
        'delivary_date',
        'unit',
        'image',
        'user_id',
    ];

    // Example relationships
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
