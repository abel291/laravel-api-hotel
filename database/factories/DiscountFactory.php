<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' =>$this->faker->bothify('?#?#?#?#') ,
            'percent' =>rand(1,100),
            'quantity' =>rand(1,100) ,
            'active' =>1 ,
        ];
    }
}
