<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = ['about-bg.jpg', 'contact-bg.jpg', 'home-bg.jpg', 'post-bg.jpg'];
        $word = fake()->word;
        return [
            'tag' => $word,
            'title' => ucfirst($word),
            'subtitle' => fake()->sentence,
            'page_image' => $images[mt_rand(0, 3)],
            'meta_description' => "Meta for $word",
            'reverse_direction' => false,
        ];
    }
}
