<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Experience;
use App\Models\ReservationUser;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $reservation_date = $this->faker->dateTimeInInterval('now','+1 month');
        
        $start_date = $reservation_date->format('Y-m-d');
        $night=rand(2,8);
        $end_date = $reservation_date->modify('+'.$night.' day')->format('Y-m-d');
        
        $room = Room::get()->random();
        $dicount = Discount::get()->random();
        
        $price=$this->faker->numberBetween(400, 500);
        
        $discount_amount=$room->price*($dicount->porcent/100);
        //dd($date_reservation);
        
          return [
            "start_date" =>$start_date,
            
            "end_date" => $end_date,
            
            "night" => $night,
            
            "discount_amount" => $discount_amount,
            
            "sub_total_price" => $room->price+$discount_amount ,  

            "total_price" => $room->price-$discount_amount ,  
            
            "check_in" => '02:30 PM',
            
            "special_request" =>"" ,
            
            "state" => $this->faker->randomElement($array = array ('canceled','refunded','successful')) ,            
            
            "canceled_date" => null,

            "room_quantity" => rand(1,3),
            
            "adults" => rand(1,3),

            "kids" => rand(1,3),

            "order" => rand(10000,99999),

            "room_reservation" => $room->only('name','beds','adults','price'),            

            "room_id" => $room->id,
            
            "discount_id" => $dicount->id,
        ];
    }
}
