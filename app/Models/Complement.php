<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon'
    ];

    protected $casts = [
        'name' => 'string',
        'icon' => 'string',
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
