<?php

namespace Database\Factories;

use App\Models\BuyerProfile;
use App\Models\ProductGroup;
use App\Models\SupplierProfile;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceInquiry>
 */
class PriceInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buyer' => BuyerProfile::inRandomOrder()->first()->id, // Adjust range as needed
            'inquiry_number' => $this->faker->unique()->numerify('INQ###'),
            'article' => $this->faker->word,
            'group' => ProductGroup::inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'cargo' => $this->faker->randomElement(['danger', 'general']),

            'cargo_place' => array_map(function () {
                $this->faker->randomElement(['china', 'hongkong']);
            }, range(1, $this->faker->numberBetween(1, 2))),

            'incoterm' => $this->faker->randomElement(['FOB', 'CIF', 'EXW', 'DDP']),
            'urgent' => $this->faker->randomElement(['true', 'false']),
            'method' => $this->faker->word,
            'color' => $this->faker->optional()->colorName,
            'packaging' => $this->faker->optional()->word,
            'requirements' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['ML Checking', 'Supplier Checking', 'ML Follow Up', 'Supplier Follow Up', 'Supplier Replied', 'ML Quoted']),
            'pcs' => array_map(function () {
                return $this->faker->numberBetween(1, 100);
            }, range(1, $this->faker->numberBetween(1, 3))),

            'supplier_ids' => array_map(function () {
                return SupplierProfile::inRandomOrder()->first()->id;
            }, range(1, $this->faker->numberBetween(1, 3))),

            'capacity' => array_map(function () {
                return $this->faker->numberBetween(1, 1024) . $this->faker->randomElement(['GB', 'mAh']);
            }, range(1, $this->faker->numberBetween(1, 3))),

        ];
    }
}
