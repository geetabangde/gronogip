<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductListing extends Model
{
    use HasFactory;

    protected $table = 'product_listings'; // If table name differs from default

    // Fillable fields for mass assignment
    protected $fillable = [
        'subcategory_id',
        'quantity',
        'selling_rate',
        'per_unit',
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
