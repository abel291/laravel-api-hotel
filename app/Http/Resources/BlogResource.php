<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->title,
            'description_min'=>$this->description_min,
            'description_max'=>$this->description_max,
            'slug'=>$this->slug,
            'img'=>$this->img,
            'active'=>$this->active,
            'seo_title'=>$this->seo_title,
            'seo_desc'=>$this->seo_desc,
            'seo_keys'=>$this->seo_keys,
        ];
    }
}
