<?php
declare(strict_types=1);
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clock>
 */
class ClockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'time_difference_seconds' => fake()->numberBetween(-50000,50000),
            'user_id' => fake()->numberBetween(1,5000),
        ];
    }
}
