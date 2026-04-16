<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    public function index(Request $request)
    {
        $vendor = $request->user()->vendor;
        $orders = $this->orderService->allByVendor($vendor->id);

        return view('vendor.orders.index', compact('orders'));
    }

    public function show(int $id, Request $request)
    {
        $order = $this->orderService->findById($id);

        abort_if(!$order || $order->vendor_id !== $request->user()->vendor->id, 403);

        return view('vendor.orders.show', compact('order'));
    }
}