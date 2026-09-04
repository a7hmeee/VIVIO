<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'file_path' => 'media/'.fake()->uuid().'.jpg',
            'type' => 'image',
            'mime_type' => 'image/jpeg',
            'size' => fake()->numberBetween(10_000, 2_000_000),
            'alt_text' => fake()->optional()->sentence(),
            'caption' => fake()->optional()->sentence(),
            'uploaded_by' => User::factory(),
        ];
    }

    public function image(): static
    {
        return $this->state(fn () => ['type' => 'image', 'mime_type' => 'image/jpeg']);
    }

    public function video(): static
    {
        return $this->state(fn () => [
            'type' => 'video',
            'mime_type' => 'video/mp4',
            'file_path' => 'media/'.fake()->uuid().'.mp4',
        ]);
    }

    public function document(): static
    {
        return $this->state(fn () => [
            'type' => 'document',
            'mime_type' => 'application/pdf',
            'file_path' => 'media/'.fake()->uuid().'.pdf',
        ]);
    }
}
