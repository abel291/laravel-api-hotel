<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
class Reservation extends Model
{
    use HasFactory;

    protected $table = "reservations";

    protected $fillable = [
        'start_date',
        'end_date',
        'night',
        'discount_percent',
        'room_quantity',
        'total_price',        
        'check_in',
        'special_request',
        'state',
        'canceled_date',
        'order',
        'room_reservation',
        'experience_reservation'
    ];
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
        'canceled_date' => 'datetime:Y-m-d',
        'room_reservation' => 'object',
        'experience_reservation' => 'object',   
        'total_price' => 'integer',   
    ];
    protected $attributes = [
        'check_in' => '02:30 PM',
        'total_price' => 0        
        
    ];

   
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Accessors & Mutators
    public function getTotalPriceCurrAttribute($value='')// no se usa
    {
        
        return '$'.number_format($this->total_price);
    }
    public function getPriceCurrAttribute()// no se usa
    {        
        return '$'.number_format($this->price);
    }

   

    
    

    
}
