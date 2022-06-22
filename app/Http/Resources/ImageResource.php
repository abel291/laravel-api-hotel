<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'image' => '/storage/images/' . $this->image,
            'thumbnail' => '/storage/images/thumbnail/' . $this->image,
            'order' => $this->order,
            'imageable' => $this->imageable,
        ];
    }
}
