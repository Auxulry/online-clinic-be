<?php

namespace App\Http\Resources\Poli;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PoliResource extends JsonResource
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
            'name' => $this->name,
            'icon' => asset('storage/' . $this->image)
        ];
    }
}
