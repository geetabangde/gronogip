<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity','manufacturer_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
   public function manufacturer()
   {
      return $this->belongsTo(Admin::class, 'manufacturer_id', 'id');
   }
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
