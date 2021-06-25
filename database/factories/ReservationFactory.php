<?php

namespace Database\Factories;

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
        $days=rand(2,8);
        $end_date = $reservation_date->modify('+'.$days.' day')->format('Y-m-d');
        
        $room = Room::get();
        $experience = Experience::get();
        
        
        
        //dd($date_reservation);      
        
          return [
            "start_date" =>$start_date,
            
            "end_date" => $end_date,
            
            "days" => $days,
            
            "discount_percent" => 0,
            
            "total_price" => $this->faker->numberBetween(40, 50)*10 ,  
            
            "check_in" => '02:30 PM',
            
            "special_request" =>"" ,
            
            "state" => $this->faker->randomElement($array = array ('canceled','refunded','successful')) ,            
            
            "canceled_date" => null,

            "room_quantity" => rand(1,3),

            "order" => rand(10000,99999),

            "room_reservation" => $room->random()->only('name','beds','adults','price'),
            "experience_reservation" => $experience->random()->only('name','price','type_price'),

            "room_id" => $room->random()->id,
            "experience_id" => $experience->random()->id,          
            
            


        ];
    }
}
