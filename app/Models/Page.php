<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'slug',
        'img',
        'seo_title',
        'seo_desc',
        'seo_keys',
        'lang',
    ];
}
