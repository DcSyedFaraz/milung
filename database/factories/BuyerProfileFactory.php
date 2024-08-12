<?php

namespace Database\Factories;

use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuyerProfile>
 */
class BuyerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buyer_id' => $this->faker->unique()->userName, // Generates a unique username
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'website' => $this->faker->url,
            'office_phone' => $this->faker->phoneNumber,
            'buyer_description' => $this->faker->sentence,
            'group' => array_map(function () {
                return ProductGroup::inRandomOrder()->first()->id;
            }, range(1, $this->faker->numberBetween(1, 5))),
        ];
    }
}
