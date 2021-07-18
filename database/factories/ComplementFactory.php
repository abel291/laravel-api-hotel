<?php

namespace Database\Factories;

use App\Models\Complement;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ComplementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Complement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->words(3, true),            
            "icon" => 'complements-'.rand(0,12).'.png',
            "price" => $this->faker->numberBetween(8, 14) ,
            "description_min" => $this->faker->text(100),
            "active" => 1,                   
            "type_price" => $this->faker->randomElement(['reservation','night']) ,
            
        ];
    }
}