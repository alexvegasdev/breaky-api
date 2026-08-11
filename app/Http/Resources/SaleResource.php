<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_amount' => (float) $this->total_amount,
            'payment_method' => $this->payment_method,
            'amount_received' => $this->amount_received !== null
                ? (float) $this->amount_received
                : null,

            'change' => $this->change !== null
                ? (float) $this->change
                : null,

            'sale_date' => $this->sale_date,
            'products' => SaleItemResource::collection(
                $this->whenLoaded('saleItems')
            ),
        ];
    }
}
