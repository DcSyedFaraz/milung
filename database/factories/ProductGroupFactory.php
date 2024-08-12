<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductGroup>
 */
class ProductGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profit = $this->faker->optional()->numberBetween(1, 100);
        $amount = $profit ? 0 : $this->faker->randomFloat(2, 1, 1000);

        return [
            'group_name' => $this->faker->unique()->words(2, true),
            'description' => $this->faker->sentence,
            'profit' => $profit,
            'amount' => $amount,
            'hs_de' => $this->faker->numberBetween(1000, 9999),
            'hs_cn' => $this->faker->numberBetween(1000, 9999),
        ];
    }
}
