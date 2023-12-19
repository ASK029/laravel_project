<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'attributes' => array_filter([
                'scientific_name' => $this->scientific_name,
                'commercial_name' => $this->commercial_name,
                'category' => $this->category,
                'manufacturer_name' => $this->manufacturer_name,
                'price' => $this->price,
                'expiration_date' => $this->expiration_date,
                'quantity_available' => $this->quantity_available,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ])
        ];
    }
}
