<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Helpers\Helpers;
class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $price=$this->faker->numberBetween(50, 200);
        return [
            "name" => $this->faker->words(3, true),
            "slug" => Str::slug($this->faker->words(3, true)) ,
            "description_min" => $this->faker->text(100),
            "description_max" => $this->faker->text(400),
            "active" => 1,
            "quantity" => $this->faker->numberBetween(5, 15),
            "beds" => $this->faker->numberBetween(3, 9),
            "adults" => $this->faker->numberBetween(3, 9),
            "kids" => $this->faker->numberBetween(0, 2),
            "price" => $price,
            "price_text" => Helpers::format_price($price),
            "thumbnail" => 'room-'.rand(0,10).'.jpg' ,
        ];
    }
}
