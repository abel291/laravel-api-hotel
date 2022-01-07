<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationRoomResource extends JsonResource
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
            'adults' => $this->adults,
            'beds' => $this->beds,
            'complements' => $this->complements,
            'id' => $this->id,
            'kids' => $this->kids,
            'name' => $this->name,
            'price' => $this->price,            
            'price_per_total_night' => $this->price_per_total_night,
            'price_text' => $this->price_text,
            'quantity' => $this->quantity,
            'quantity_availables' => $this->quantity_availables,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,

        ];
    }
}
