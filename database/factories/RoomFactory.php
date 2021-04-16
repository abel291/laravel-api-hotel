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
            "description-min" => $this->faker->text(100),
            "description-max" => $this->faker->text(200),
            "image" => $this->faker->imageUrl(360, 360, 'animals', true, 'cats'),
            "quantity" => $this->faker->numberBetween(3, 9),
            "price" => $this->faker->numberBetween(40, 50)*100 
        ];
    }
}
