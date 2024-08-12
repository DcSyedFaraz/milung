<?php

namespace Database\Factories;

use App\Models\BuyerProfile;
use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\SupplierProfile;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'accessories' => $this->faker->word,
            'article' => Products::inRandomOrder()->first()->article,
            'atc_number' => $this->faker->word,
            'capacity' => array_map(function () {
                return $this->faker->numberBetween(1, 1024) . $this->faker->randomElement(['GB', 'mAh']);
            }, range(1, $this->faker->numberBetween(1, 3))),
            'buyeremail' => $this->faker->email,
            // 'buyerorder' => $this->faker->word,
            'ftyitem' => $this->faker->word,
            'logocolor' => array_map(function () {
                return $this->faker->colorName;
            }, range(1, $this->faker->numberBetween(1, 3))),
            'group' => ProductGroup::inRandomOrder()->first()->id,
            'incoterm' => $this->faker->word,
            'inquiry' => $this->faker->word,
            'milungorder' => $this->faker->word,
            'notice' => ["PV to Customer"],
            'orderdate' => $this->faker->date,
            'orderremarks' => $this->faker->sentence,
            'packaging' => $this->faker->word,
            'packagingprinting' => array_map(function () {
                return $this->faker->words($this->faker->numberBetween(2, 5));
            }, range(1, $this->faker->numberBetween(1, 3))),
            'printingmethod' => $this->faker->word,
            'productcolor' => $this->faker->word,
            'productname' => $this->faker->word,
            'qcremarks' => $this->faker->sentence,
            'quantity_unit' => $this->faker->numberBetween(1, 1024) . $this->faker->randomElement(['units', 'pairs', 'sets']),
            'reference' => $this->faker->word,
            'sendoutdate' => $this->faker->date,
            'ship_doc' => $this->faker->word,
            'so_number' => $this->faker->randomNumber(),
            'status' => $this->faker->randomElement([
                'New Order',
                'Printview Confirmation',
                'Printview Reject',
                'Order Confirm',
                'Cargo Ready',
                'Shipment Approval',
                'Export/Import',
                'Delivered',
            ]),
            'buyer' => BuyerProfile::inRandomOrder()->first()->id,
            'supplier' => SupplierProfile::inRandomOrder()->first()->id,
            'sellingprice' => number_format($this->faker->randomFloat(2, 1, 100), 2),
            'buyingprice' => number_format($this->faker->randomFloat(2, 1, 99.99), 2),
            'totalvalue' => number_format($this->faker->randomFloat(2, 1, 99.99), 2),

        ];
    }
}
