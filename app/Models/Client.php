<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;
class Client extends Model
{
    use HasFactory, Billable;
    protected $fillable = ['name','email','phone','country','city'];
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
