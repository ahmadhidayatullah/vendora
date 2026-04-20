<?php

namespace App\Models;

use App\Enums\Payment\PaymentIntentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentIntent extends Model
{
    protected $fillable = [
        'order_id',
        'intent_key',
        'amount',
        'status',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'status'   => PaymentIntentStatus::class,
        'metadata' => 'array',
        'paid_at'  => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isSucceeded(): bool
    {
        return $this->status === PaymentIntentStatus::SUCCEEDED;
    }

    public function isFailed(): bool
    {
        return $this->status === PaymentIntentStatus::FAILED;
    }
}