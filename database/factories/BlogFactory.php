<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description_min' => $this->faker->text(100),
            'description_max' => $this->faker->randomHtml(),
            'slug' => Str::slug($this->faker->sentence()),
            'img' => 'post-'.rand(0,10).'.jpg',
            'active' => rand(0,1),
            'seo_title' => $this->faker->sentence(),
            'seo_desc' => $this->faker->sentence(),
            'seo_keys' => $this->faker->sentence(),
           
        ];
    }
}
