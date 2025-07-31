<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Car */
class CarsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'driver_id' => $this->driver_id,
            'comfort_category' => $this->comfort_category,

            'driver' => DriverResource::make($this->whenLoaded('driver')),
        ];
    }
}
