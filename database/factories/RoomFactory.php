<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        return [
            "name" => $this->faker->words(3, true),
            "slug" => str::slug($this->faker->words(3, true)) ,
            "description_min" => $this->faker->text(100),
            "description_max" => $this->faker->text(400),
            "active" => rand(0,1),
            "quantity" => $this->faker->numberBetween(3, 9),
            "beds" => $this->faker->numberBetween(3, 9),
            "people" => $this->faker->numberBetween(3, 9),
            "price" => $this->faker->numberBetween(40, 50)*100 ,
            "thumbnail" => null ,
        ];
    }
}
