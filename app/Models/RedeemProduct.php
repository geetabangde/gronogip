<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemProduct extends Model
{
    use HasFactory;

    protected $fillable = ['redeem_product_name', 'redeem_product_coins', 'redeem_product_image', 'redeem_product_description'];
}
