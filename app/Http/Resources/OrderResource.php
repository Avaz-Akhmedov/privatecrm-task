<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'tarrif_id' => $this->tarrif_id,
            'schedule_type' => $this->schedule_type,
            'comment' => $this->comment,
            'first_date' => $this->first_date,
            'last_date' => $this->last_date,
            'created_at' => $this->created_at->toDateTimeString(),
            'tarrif' => TarrifResource::make($this->whenLoaded('tarrif')),
            'rations' => RationResource::collection($this->whenLoaded('rations')),
        ];
    }
}
