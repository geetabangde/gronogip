<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Brand extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'image','description', 'status','manufacturer_id'];

    public function manufacturer()
   {
      return $this->belongsTo(Admin::class, 'manufacturer_id');
   }

}
