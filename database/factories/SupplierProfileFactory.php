<?php

namespace Database\Factories;

use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplierProfile>
 */
class SupplierProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => $this->faker->unique()->userName, // Generates a unique username
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'website' => $this->faker->url,
            'office_phone' => $this->faker->phoneNumber,
            'supplier_description' => $this->faker->sentence,
            'group' => array_map(function () {
                return ProductGroup::inRandomOrder()->first()->id;
            }, range(1, $this->faker->numberBetween(1, 5))),
            'sec_group' => array_map(function () {
                return ProductGroup::inRandomOrder()->first()->id;
            }, range(1, $this->faker->numberBetween(1, 5))),
            'company_header' => $this->faker->companySuffix,
            'bank' => $this->faker->name,
            'bank_address' => $this->faker->address,
            'swift_code' => strtoupper($this->faker->bothify('???###')), // Generates random SWIFT code-like string
            'chips_no' => strtoupper($this->faker->bothify('??????')), // Generates random CHIPS number-like string
            'beneficiary_name' => $this->faker->name,
            'account_no' => $this->faker->bankAccountNumber,
        ];
    }
}
