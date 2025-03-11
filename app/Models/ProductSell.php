<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSell extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'product_name', 'quantity', 'price', 'description'];

    public function category()
   {
    
    return $this->belongsTo(Category::class, 'category_id');
   } 
   public function subcategory()
   {
    return $this->belongsTo(Subcategory::class, 'subcategory_id');
   }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }


}
