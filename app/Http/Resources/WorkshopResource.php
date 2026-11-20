<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Workshop */
class WorkshopResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'discipline' => [
                'value' => $this->discipline->value,
                'label' => $this->discipline->label(),
                'color' => $this->discipline->color(),
            ],
            'instructor' => $this->instructor,
            'starts_at' => $this->starts_at->toIso8601String(),
            'duration_minutes' => $this->duration_minutes,
            'capacity' => $this->capacity,
            'seats_left' => $this->seats_left,
            'price_cents' => $this->price_cents,
        ];
    }
}
