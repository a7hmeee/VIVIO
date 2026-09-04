<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'short_description' => fake()->sentence(),
            'client' => fake()->company(),
            'featured_image' => null,
            'video' => null,
            'problem' => fake()->paragraphs(2, true),
            'solution' => fake()->paragraphs(2, true),
            'approach' => fake()->paragraphs(2, true),
            'result' => fake()->paragraphs(2, true),
            'technologies' => array_slice(['Laravel', 'Livewire', 'Tailwind', 'React', 'Vue', 'Three.js', 'GSAP', 'Filament'], 0, rand(2, 5)),
            'year' => fake()->numberBetween(2015, 2026),
            'is_featured' => false,
            'is_published' => true,
            'published_at' => now(),
            'sort_order' => 0,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function draft(): static
    {
        return $this->unpublished();
    }

    public function withMedia(int $count = 3): static
    {
        return $this->afterCreating(function (Project $project) use ($count) {
            ProjectMedia::factory()
                ->count($count)
                ->for($project)
                ->create();
        });
    }
}
