<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = ['about-bg.jpg', 'contact-bg.jpg', 'home-bg.jpg', 'post-bg.jpg'];
        $title = fake()->sentence(mt_rand(3, 10));
        return [
            'title' => $title,
            'subtitle' => Str::limit(fake()->sentence(mt_rand(10, 20)), 252),
            'page_image' => $images[mt_rand(0, 3)],
            'content_raw' => join("\n\n", fake()->paragraphs(mt_rand(3, 6))),
            'published_at' => fake()->dateTimeBetween('-1 month', '+3 days'),
            'meta_description' => "Meta for $title",
            'is_draft' => false,
        ];
    }
}
