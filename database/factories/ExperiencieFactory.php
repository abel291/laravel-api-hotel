<?php

namespace Database\Factories;

use App\Models\Experiencie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ExperiencieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Experiencie::class;

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
            "price" => $this->faker->numberBetween(40, 50) ,
            "type_price" => $this->faker->randomElement(['reservation','night']) ,
            "thumbnail" => 'asd' ,
        ];
    }
}
