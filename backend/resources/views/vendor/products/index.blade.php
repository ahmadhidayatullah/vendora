@extends('vendor.layout')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Products</h1>
    <a href="{{ route('vendor.products.create') }}"
       class="bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700">
        + New Product
    </a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Price</th>
                <th class="px-6 py-3">Stock</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $product->status->value === 1 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $product->status->name }}
                    </span>
                </td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('vendor.products.edit', $product->id) }}"
                       class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('vendor.products.destroy', $product->id) }}"
                          onsubmit="return confirm('Delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                    No products yet. <a href="{{ route('vendor.products.create') }}" class="text-green-600 hover:underline">Create one</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection