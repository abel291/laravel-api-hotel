<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    protected $table ='blog';
    protected $fillable = [
        'title',
        'description_min',
        'description_max',
        'slug',
        'img',
        'active',
        'seo_title',
        'seo_desc',
        'seo_keys',
        
    ];

    protected $casts = [
        'title' => 'string',
        'description_min' => 'string',
        'description_max' => 'string',
        'slug' => 'string',  
        'img' => 'string',        
        'active' => 'boolean',        
        'seo_title' => 'string',
        'seo_desc' => 'string',
        'seo_keys' => 'string',

    ];
    protected $attributes = [
        'active' => 0,
    ];
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
