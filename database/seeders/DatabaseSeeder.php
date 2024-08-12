<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BuyerProfile;
use App\Models\Order;
use App\Models\PriceInquiry;
use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\SupplierProfile;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $this->call([
                // PermissionTableSeeder::class,
            ]);
            $this->seedothers();
            // $this->call([OtherSeeder::class]); // Example of calling additional seeders
        } catch (\Exception $e) {
            // Handle errors gracefully
            echo "Seeding failed: " . $e->getMessage();
        }
    }

    private function seedothers()
    {
        // try {
            ProductGroup::factory()->count(5)->create();

            SupplierProfile::factory()->count(5)->create();

            BuyerProfile::factory()->count(5)->create();

            User::factory()->count(10)->Supplier()->create();
            User::factory()->count(10)->Buyer()->create();

            Products::factory()->count(5)->create();

            PriceInquiry::factory()->count(5)->create();

            Order::factory()->count(5)->create();

        // } catch (\Exception $e) {
        //     // Handle file reading errors
        //     echo "Error reading SQL file: " . $e->getMessage();
        // }
    }
}
