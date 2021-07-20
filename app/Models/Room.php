<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description_min',
        'description_max',        
        'quantity',
        'price',
        'active',
        'thumbnail',
        'beds',
        'adults',        
        'breakfast',
        'breakfast_price'
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
        'adults' => 'integer',        
    ];

    protected $attributes = [
        'active' => 0,
        'quantity' => 0,
        'price' => 0,
        'beds' => 0,
        'adults' => 0,
        'breakfast' => false,
        'breakfast_price' => 0,        
    ];


    /**
     * Get the post's image.
     */
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    
    
    public function complements()
    {
        return $this->belongsToMany(Complement::class);
    }

    public function experiences()
    {
        return $this->belongsToMany(Experience::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Accessors & Mutators
    public function getThumbnailPathAttribute($value='')
    {
        return '/storage/rooms/thumbnail/'.$this->thumbnail;
    }
    public function getImagePathAttribute($value='')
    {
        return '/storage/rooms/'.$this->thumbnail;
    }
}
