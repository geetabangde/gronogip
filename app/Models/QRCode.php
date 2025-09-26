<?php
// app/Models/QRCode.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'razorpay_qr_id',
        'image_url',
        'usage',
        'fixed_amount',
        'payment_amount',
        'description',
        'notes',
        'status',
    ];

    protected $casts = [
        'notes' => 'array',
        'fixed_amount' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(QRPayment::class, 'qr_code_id');
    }

}
