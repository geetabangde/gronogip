<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'name', 'category_id', 'price', 'description'];

    
    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault([
            'name' => 'No Category', // Default value if category is null
        ]);
    }
}
