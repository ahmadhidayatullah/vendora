<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'order_number'   => $this->order_number,
            'status'         => $this->status->name,
            'payment_status' => $this->payment_status->name,
            'total_amount'   => number_format($this->total_amount, 2),
            'vendor'         => $this->whenLoaded('vendor', fn() => [
                'id'   => $this->vendor->id,
                'name' => $this->vendor->name,
            ]),
            'customer'       => $this->whenLoaded('user', fn() => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ]),
            'items'          => $this->whenLoaded('items', fn() =>
                $this->items->map(fn($item) => [
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name ?? null,
                    'quantity'     => $item->quantity,
                    'unit_price'   => number_format($item->unit_price, 2),
                    'subtotal'     => number_format($item->subtotal, 2),
                ])
            ),
            'created_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}