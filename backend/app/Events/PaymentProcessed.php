<?php

namespace App\Events;

use App\Models\PaymentIntent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentProcessed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly PaymentIntent $paymentIntent,
        public readonly bool          $succeeded,
    ) {}
}
