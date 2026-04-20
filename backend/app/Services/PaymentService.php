<?php

namespace App\Services;

use App\Enums\Order\PaymentStatus;
use App\Enums\Payment\PaymentIntentStatus;
use App\Events\PaymentProcessed;
use App\Models\Order;
use App\Models\PaymentIntent;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function initiatePayment(Order $order): PaymentIntent
    {
        $intent = $order->paymentIntent;

        abort_if(!$intent, 404, 'No payment intent found for this order.');
        abort_if($intent->isSucceeded(), 422, 'Order is already paid.');

        // Move intent to processing
        $intent->update(['status' => PaymentIntentStatus::PROCESSING]);

        return $intent;
    }

    public function handleWebhook(string $intentKey, bool $succeeded): void
    {
        $intent = PaymentIntent::where('intent_key', $intentKey)->firstOrFail();

        DB::transaction(function () use ($intent, $succeeded) {
            if ($succeeded) {
                $intent->update([
                    'status'  => PaymentIntentStatus::SUCCEEDED,
                    'paid_at' => now(),
                ]);
            } else {
                $intent->update([
                    'status' => PaymentIntentStatus::FAILED,
                ]);
            }

            // Fire event — listener is queued, runs async
            PaymentProcessed::dispatch($intent, $succeeded);
        });
    }
}
