<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TarrifResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ration_name' => $this->ration_name,
            'cooking_day_before' => $this->cooking_day_before,
        ];
    }
}
