<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'sub_title' => $this->faker->sentence(),
            'content' => $this->faker->randomHtml(4),            
            'slug' => Str::slug($this->faker->sentence()),
            'img' => $this->faker->imageUrl(360, 360, 'animals', true),            
            'seo_title' => $this->faker->sentence(),
            'seo_desc' => $this->faker->sentence(),
            'seo_keys' => $this->faker->sentence(),
            'lang' => 'es',
        ];
    }
}
