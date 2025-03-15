<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    protected $fillable = ['user_id', 'redeem_product_id', 'coins_used'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function redeemproduct() {
        return $this->belongsTo(RedeemProduct::class, 'redeem_product_id');
    }
}

