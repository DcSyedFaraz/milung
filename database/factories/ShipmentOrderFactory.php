<?php

namespace Database\Factories;

use App\Models\BuyerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentOrder>
 */
class ShipmentOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'so_number' => Str::random(10),
            'buyerid' => BuyerProfile::inRandomOrder()->first()->id,
            'method' => $this->faker->word(),
            'port' => $this->faker->city(),
            'remarks' => $this->faker->paragraph(),
            'destination' => $this->faker->city(),
            'incoterm' => $this->faker->word(),
        ];
    }
}
