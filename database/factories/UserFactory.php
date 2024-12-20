<?php

namespace Database\Factories;

use App\Models\BuyerProfile;
use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'supplier_id' => null,
            'userid' => 'new',
            'buyer_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function Buyer(): static
    {
        $buyer = BuyerProfile::inRandomOrder()->first();

        return $this->state(fn(array $attributes) => [
            'buyer_id' => $buyer->id,
            'supplier_id' => null,
        ])->afterCreating(function (User $user) use ($buyer) {
            $user->assignRole('Buyer');

            $user->userid = $buyer->buyer_id . '-' . fake()->unique()->userName;

            $user->save();
        });
    }


    public function Supplier(): static
    {
        $supplier = SupplierProfile::inRandomOrder()->first();

        return $this->state(fn(array $attributes) => [
            'supplier_id' => $supplier->id,
            'buyer_id' => null,
        ])->afterCreating(function (User $user) use ($supplier) {
            $user->assignRole('Supplier');

            $user->userid = $supplier->supplier_id . '-' . fake()->unique()->userName;

            $user->save();
        });
    }

}
