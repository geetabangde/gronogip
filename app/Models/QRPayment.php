<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code_id',
        'razorpay_payment_id',
        'amount',
        'currency',
        'status',
        'method',
        'vpa',
        'email',
        'contact',
        'notes',
        'fee',
        'tax',
        'rrn',
        'paid_at',
    ];

    protected $casts = [
        'notes' => 'array',
        'paid_at' => 'datetime',
    ];

    /**
     * Relation: ek payment ek QR code se belong karti hai
     */
    public function qrCode()
    {
        return $this->belongsTo(QRCode::class, 'qr_code_id');
    }
}
