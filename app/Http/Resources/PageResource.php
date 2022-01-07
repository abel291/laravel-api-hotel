<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'slug' => $this->slug,
            'img' => $this->img ? '/storage/pages/' . $this->img : null,
            'seo_title' => $this->seo_title,
            'seo_desc' => $this->seo_desc,
            'seo_keys' => $this->seo_keys,
            'lang' => $this->lang,
        ];
    }
}
