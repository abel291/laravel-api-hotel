<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description_min',
        'description_max',
        'price',        
        'type_price',        
        'active',
        'thumbnail',      
        
    ];    

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'description_min' => 'string',
        'description_max' => 'string',  
        'price' => 'integer',        
        'type_price' => 'string',        
        'active' => 'boolean',
        'thumbnail' => 'string',

    ];
    protected $attributes = [
        'active' => 0,        
        'price' => 0,
        'type_price' => 'reservation',
        
    ];


    /**
     * Get the post's image.
     */
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // Accessors & Mutators
    public function getThumbnailPathAttribute($value='')
    {
        return '/storage/experiencie/thumbnail/'.$this->thumbnail;
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
