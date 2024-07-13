<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
             $this->call([
            PermissionTableSeeder::class,
        ]);
        $this->seedSupplierProfiles();
            // $this->call([OtherSeeder::class]); // Example of calling additional seeders
        } catch (\Exception $e) {
            // Handle errors gracefully
            echo "Seeding failed: " . $e->getMessage();
        }
    }

    private function seedSupplierProfiles()
    {
        try {
            $sql = file_get_contents(base_path('database/seeders/milung.sql'));
            // $sql1 = file_get_contents(base_path('database/seeders/supplier_profiles.sql'));
            $sql2 = file_get_contents(base_path('database/seeders/orders.sql'));
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::statement($sql);
            // DB::statement($sql1);
            DB::statement($sql2);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {
            // Handle file reading errors
            echo "Error reading SQL file: " . $e->getMessage();
        }
    }
}
