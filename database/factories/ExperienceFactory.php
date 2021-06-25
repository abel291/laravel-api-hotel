<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->words(3, true),
            "slug" => Str::slug($this->faker->words(3, true)) ,
            "description_min" => $this->faker->text(100),
            "description_max" => $this->faker->text(400),
            "active" => rand(0,1),                      
            "price" => $this->faker->numberBetween(8, 14)*10 ,
            "type_price" => $this->faker->randomElement(['reservation','nigth']) ,
            "thumbnail" => 'asd' ,
        ];
    }
}
