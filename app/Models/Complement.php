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
        'price',
        'type_price',
        'active',
        'description_min',
    ];

    protected $casts = [
        'name' => 'string',
        'icon' => 'string',
        'price' => 'integer',
        'type_price' => 'string',
        'active' => 'boolean',
        'description_min' => 'string',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
    public function getIconPathAttribute($value='')
    {
        return '/storage/complements/'.$this->icon;
    }
}
