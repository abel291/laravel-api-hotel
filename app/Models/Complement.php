<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description_min',
        'price',
        'type_price',
        'active',
    ];

    protected $casts = [
        'name' => 'string',
        'description_min' => 'string',
        'price' => 'float',
        'type_price' => 'string',
        'active' => 'boolean',
    ];
    protected $attributes = [
        'active' => 0,        
        'price' => 0,
        'type_price' => 'reservation',
        
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
    public function getIconPathAttribute()
    {   
        return '/storage/complements/'.$this->icon;
    }
}
