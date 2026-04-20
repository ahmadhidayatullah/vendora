<?php

namespace App\Listeners;

use App\Enums\Order\OrderStatus;
use App\Enums\Order\PaymentStatus;
use App\Events\PaymentProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrderPaymentListener implements ShouldQueue
{
    public function handle(PaymentProcessed $event): void
    {
        $order = $event->paymentIntent->order;

        if ($event->succeeded) {
            $order->update([
                'payment_status' => PaymentStatus::PAID,
                'status'         => OrderStatus::PROCESSING,
            ]);
        } else {
            $order->update([
                'payment_status' => PaymentStatus::FAILED,
            ]);
        }
    }
}
