<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly OrderService   $orderService,
    ) {}

    // Customer calls this to "pay" for their order
    public function pay(int $orderId, Request $request): JsonResponse
    {
        $order = $this->orderService->findById($orderId);

        abort_if(!$order, 404, 'Order not found.');
        abort_if($order->user_id !== $request->user()->id, 403, 'Forbidden.');

        $intent = $this->paymentService->initiatePayment($order);

        return response()->json([
            'message'    => 'Payment initiated.',
            'intent_key' => $intent->intent_key,
            'amount'     => $intent->amount,
            'status'     => $intent->status->name,
        ]);
    }

    // Simulates Stripe calling back your webhook endpoint
    public function webhook(Request $request): JsonResponse
    {
        $request->validate([
            'intent_key' => ['required', 'string'],
            'succeeded'  => ['required', 'boolean'],
        ]);

        $this->paymentService->handleWebhook(
            $request->intent_key,
            $request->boolean('succeeded'),
        );

        return response()->json(['message' => 'Webhook processed.']);
    }
}
