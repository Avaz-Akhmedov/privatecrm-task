<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RationResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cooking_date' => $this->cooking_date,
            'delivery_date' => $this->delivery_date,
            'order_id' => $this->order_id,
        ];
    }
}
