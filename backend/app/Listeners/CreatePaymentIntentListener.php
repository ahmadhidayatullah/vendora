<?php

namespace App\Listeners;

use App\Enums\Payment\PaymentIntentStatus;
use App\Events\OrderCreated;
use App\Models\PaymentIntent;
use Illuminate\Support\Str;

class CreatePaymentIntentListener
{
    public function handle(OrderCreated $event): void
    {
        PaymentIntent::create([
            'order_id'   => $event->order->id,
            'intent_key' => 'pi_' . Str::random(24),
            'amount'     => $event->order->total_amount,
            'status'     => PaymentIntentStatus::PENDING,
            'metadata'   => [
                'order_number' => $event->order->order_number,
                'vendor_id'    => $event->order->vendor_id,
                'user_id'      => $event->order->user_id,
            ],
        ]);
    }
}
