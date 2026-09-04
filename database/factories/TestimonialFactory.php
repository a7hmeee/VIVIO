<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'project_id' => null,
            'client_name' => fake()->name(),
            'company' => fake()->company(),
            'position' => fake()->jobTitle(),
            'quote' => fake()->sentence(15),
            'avatar' => null,
            'is_featured' => false,
            'is_published' => false,
            'sort_order' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['is_published' => true]);
    }
}
