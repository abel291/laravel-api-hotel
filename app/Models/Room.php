<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description_min',
        'description_max',        
        'quantity',
        'price',
        'active',
        'beds',
        'people',
    ];


    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'description_min' => 'string',
        'description_max' => 'string',        
        'quantity' => 'integer',
        'price' => 'integer',        
        'active' => 'boolean',
        'beds' => 'integer',
        'people' => 'integer',
    ];
    protected $attributes = [
        'active' => 0,
        'quantity' => 0,
        'price' => 0,
        'beds' => 0,
        'people' => 0,
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
        return '/storage/rooms/thumbnail/'.$this->thumbnail;
    }

    public function complements()
    {
        return $this->belongsToMany(Complement::class);
    }

    public function experiencies()
    {
        return $this->belongsToMany(Experiencie::class);
    }

}
