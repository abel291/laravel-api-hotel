<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description_min' => $this->description_min,
            'description_max' => $this->description_max,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'price_text' => $this->price_text,
            'active' => $this->active,
            'beds' => $this->beds,
            'adults' => $this->adults,
            'kids' => $this->kids,
            'thumbnail' => $this->thumbnail,
            'images' => $this->thumbnail,
            'complements' => ComplementResource::collection($this->whenLoaded('complements')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
