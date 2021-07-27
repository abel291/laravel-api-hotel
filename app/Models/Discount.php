<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'percent',
        'quantity',
        'active'
    ];

    protected $casts = [
        'code' => 'string',
        'percent' => 'integer',
        'quantity' => 'integer',
        'active' => 'boolean',

    ];
    protected $attributes = [
        'active' => 1,          
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
