<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'booking_id',
        'amount',
        'reference_id',
        'gcash_checkout_url',
        'payment_date',
        'status',
        'hash',
        'gateway_name',
        'payment_request_log',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';

    const STATUS = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_FAILED
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
