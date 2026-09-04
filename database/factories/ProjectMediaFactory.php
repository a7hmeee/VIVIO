<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectMediaFactory extends Factory
{
    protected $model = ProjectMedia::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['image', 'video', 'document']);

        return [
            'project_id' => Project::factory(),
            'type' => $type,
            'path' => 'projects/'.fake()->uuid().'.'.match ($type) {
                'image' => fake()->randomElement(['jpg', 'png', 'webp']),
                'video' => 'mp4',
                'document' => 'pdf',
            },
            'alt_text' => fake()->optional()->sentence(),
            'caption' => fake()->optional()->sentence(),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'image',
            'path' => 'projects/'.fake()->uuid().'.jpg',
        ]);
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'video',
            'path' => 'projects/'.fake()->uuid().'.mp4',
        ]);
    }

    public function document(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'document',
            'path' => 'projects/'.fake()->uuid().'.pdf',
        ]);
    }
}
