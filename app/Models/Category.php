<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug', 'photo','status'];
    public $timestamps = false;

    // Define relationship: Category has many Products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
