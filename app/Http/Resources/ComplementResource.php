<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplementResource extends JsonResource
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
            'icon' => $this->icon,
            'description_min' => $this->description_min,
            'price' => $this->price,
            'type_price' => $this->type_price,
        ];
    }
}
