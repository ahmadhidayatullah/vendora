@extends('vendor.layout')

@section('content')
<div class="mb-6">
    <a href="{{ route('vendor.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to orders</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Order {{ $order->order_number }}</h1>
</div>

<div class="grid grid-cols-3 gap-6">

    {{-- Order Items --}}
    <div class="col-span-2 bg-white rounded shadow overflow-hidden">
        <div class="px-6 py-4 border-b text-sm font-semibold text-gray-700">Items</div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Product</th>
                    <th class="px-6 py-3 text-right">Unit Price</th>
                    <th class="px-6 py-3 text-right">Qty</th>
                    <th class="px-6 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4">{{ $item->product->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="px-6 py-4 text-right">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-right">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-semibold text-gray-700">Total</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Order Summary --}}
    <div class="space-y-4">
        <div class="bg-white rounded shadow p-5 text-sm">
            <p class="font-semibold text-gray-700 mb-3">Order Info</p>
            <div class="space-y-2 text-gray-600">
                <div class="flex justify-between">
                    <span>Status</span>
                    <span class="font-medium">{{ $order->status->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Payment</span>
                    <span class="font-medium">{{ $order->payment_status->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Date</span>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-5 text-sm">
            <p class="font-semibold text-gray-700 mb-3">Customer</p>
            <p class="text-gray-800">{{ $order->user->name }}</p>
            <p class="text-gray-500">{{ $order->user->email }}</p>
        </div>
    </div>

</div>
@endsection