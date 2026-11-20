<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Booking */
class BookingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'workshop' => $this->workshop->slug,
            'name' => $this->name,
            'seats' => $this->seats,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
