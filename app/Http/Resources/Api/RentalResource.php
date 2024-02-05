<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'book' => new BookResource($this->book),
            'rental_date' => $this->rental_date,
            'due_date' => (string) $this->due_date,
            'return_date' => (string) $this->return_date,
            'status' => (string) $this->status,
        ];
    }
}
