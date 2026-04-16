<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'price'       => number_format($this->price, 2),
            'stock'       => $this->stock,
            'in_stock'    => $this->isInStock(),
            'status'      => $this->status->name,
            'vendor'      => $this->whenLoaded('vendor', fn() => [
                'id'   => $this->vendor->id,
                'name' => $this->vendor->name,
            ]),
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}