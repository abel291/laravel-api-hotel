<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','active'];
    
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'active' => 'boolean'
    ];
    protected $attributes = [
        'active' => 0,
    ];

    public function posts()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag', 'tag_id', 'blog_id');
    }
}
