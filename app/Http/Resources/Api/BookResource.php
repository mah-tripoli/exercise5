<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => (string) $this->title,
            'author' => (string) $this->author,
            'isbn' => (string) $this->isbn,
            'publish_year' => (int) $this->publish_year,
            'genre' => $this->genre,
            'available_quantity' => (int) $this->available_quantity,
            'description' => (string) $this->description,
            'cover_url' => (string) $this->cover_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
