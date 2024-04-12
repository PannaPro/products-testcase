<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attributes = [
            'color' => $this->faker->colorName,
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
        ];

        return [
            'article' => Str::upper($this->faker->unique()->regexify('[A-Z0-9]{10}')),
            'name' => $this->faker->sentence(rand(3, 5)),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'attributes' => $attributes,
            'created_at' => fake()->dateTimeBetween('-4 months', now()),
            'updated_at' => now(),
        ];
    }
}
