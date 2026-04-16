@extends('vendor.layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Order #</th>
                <th class="px-6 py-3">Customer</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Payment</th>
                <th class="px-6 py-3">Date</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-mono text-xs text-gray-700">{{ $order->order_number }}</td>
                <td class="px-6 py-4">{{ $order->user->name }}</td>
                <td class="px-6 py-4">${{ number_format($order->total_amount, 2) }}</td>
                <td class="px-6 py-4">
                    @php
                        $statusColors = [1 => 'bg-yellow-100 text-yellow-700', 2 => 'bg-blue-100 text-blue-700', 3 => 'bg-green-100 text-green-700', 4 => 'bg-red-100 text-red-600'];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$order->status->value] ?? 'bg-gray-100 text-gray-500' }}">
                        {{ $order->status->name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @php
                        $paymentColors = [1 => 'bg-gray-100 text-gray-500', 2 => 'bg-green-100 text-green-700', 3 => 'bg-red-100 text-red-600', 4 => 'bg-purple-100 text-purple-600'];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs {{ $paymentColors[$order->payment_status->value] ?? '' }}">
                        {{ $order->payment_status->name }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('vendor.orders.show', $order->id) }}"
                       class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">No orders yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection