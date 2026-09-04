<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->optional()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'project_type' => fake()->randomElement(['Website', 'Branding', 'E-commerce', 'Application']),
            'budget' => fake()->optional()->randomElement(['<50K SAR', '50-100K SAR', '100K+ SAR']),
            'message' => fake()->paragraph(3),
            'status' => 'new',
            'source' => fake()->optional()->randomElement(['website', 'referral', 'social']),
        ];
    }
}
