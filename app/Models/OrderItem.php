<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
     protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price', 'subtotal','manufacturer_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function manufacturer() {
       return $this->belongsTo(Admin::class, 'manufacturer_id');
   }



}
