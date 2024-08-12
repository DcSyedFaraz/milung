<?php

namespace Database\Factories;

use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article' => $this->faker->unique()->word,
            'standart_packaging' => $this->faker->word,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'name' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'group' => ProductGroup::inRandomOrder()->first()->id,
            'cargo' => $this->faker->randomElement(['danger', 'general']),
            'cargo_place' => $this->faker->randomElement(['china', 'hongkong']),
            'color' => $this->faker->safeColorName,
            'material' => $this->faker->word,
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'weight' => $this->faker->randomFloat(2, 0.1, 100),
            'specification' => $this->faker->sentence,
            'memory' => $this->faker->randomElement(['8GB', '16GB', '32GB']),
            'feature' => $this->faker->word,
            'accessory' => $this->faker->word,
            'accessory_weight' => $this->faker->randomFloat(2, 0.1, 5),
            'battery_type' => $this->faker->word,
            'rated' => $this->faker->word,
            'capacity' => $this->faker->randomFloat(2, 0.1, 1000),
            'voltage' => $this->faker->randomFloat(2, 1, 240),
            'pcs' => $this->faker->numberBetween(1, 100),
            'mAh' => $this->faker->randomNumber(4),
            'mm' => $this->faker->randomNumber(3),
            'gram' => $this->faker->randomFloat(2, 0.1, 500),
            'edition' => $this->faker->word,
            'msds_expiry' => $this->faker->date(),
            'un_expiry' => $this->faker->date(),
            'quoteExpiredDate' => $this->faker->date(),
            'air_safety_expiry' => $this->faker->date(),
            'sea_safety_expiry' => $this->faker->date(),
            'train_safety_expiry' => $this->faker->date(),
            'certificate' => $this->faker->word,
            'printing_method' => $this->faker->word,
            'unit_packaging_paper' => $this->faker->numberBetween(1, 100),
            'unit_packaging_plastic' => $this->faker->numberBetween(1, 100),
            'unit_packaging_metal' => $this->faker->numberBetween(1, 100),
            'unit_packaging_others' => $this->faker->numberBetween(1, 100),
            'packaging_material' => $this->faker->word,
            'packaging_weight' => $this->faker->numberBetween(1, 100),
        ];
    }
}
