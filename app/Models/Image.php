<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['image','thumbnail','order'];
    
    
    public function imageable()
    {
        return $this->morphTo();
    }
    

    // Accessors & Mutators
    public function getImagePathAttribute($value='')
    {
    	return '/storage/images/'.$this->image;
    }
}
