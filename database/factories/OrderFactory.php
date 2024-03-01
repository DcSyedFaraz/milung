<?php

namespace Database\Factories;

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
            'linked_order' => null,
            'accessories' => $faker->sentence,
            'article' => $faker->word,
            'atc_number' => $faker->word,
            'buyer' => $faker->name,
            'capacity' => $faker->randomFloat(2, 0, 100),
            'buyeremail' => $faker->safeEmail,
            'buyerorder' => $faker->word,
            'buyingprice' => $faker->randomFloat(2, 0, 100),
            'ftyitem' => $faker->word,
            'logocolor' => $faker->colorName,
            'group' => $faker->randomDigitNotNull,
            'incoterm' => $faker->word,
            'inquiry' => $faker->sentence,
            'milungorder' => $faker->word,
            'notice' => '[]',
            'orderdate' => $faker->date,
            'orderremarks' => $faker->sentence,
            'packaging' => $faker->word,
            'packagingprinting' => $faker->word,
            'printingmethod' => $faker->word,
            'productcolor' => $faker->colorName,
            'productname' => $faker->word,
            'qcremarks' => $faker->sentence,
            'quantity_unit' => $faker->word,
            'reference' => $faker->word,
            'logoFiles' => '[]',
            'manualFiles' => '[]',
            'safetySheetFiles' => '[]',
            'labelFiles' => '[]',
            'files' => '[]',
            'sellingprice' => $faker->randomFloat(2, 0, 100),
            'sendoutdate' => $faker->date,
            'ship_doc' => $faker->word,
            'so_number' => $faker->word,
            'status' => $faker->word,
            'supplier' => $faker->name,
            'totalvalue' => $faker->randomFloat(2, 0, 100),
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTime,
        ];
    }
}
