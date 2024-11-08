<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class ScoutImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:import-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import multiple models into Algolia using Laravel Scout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Define the models you want to import
        $models = [
            'App\Models\Order',
            'App\Models\Products',
            'App\Models\User',
            'App\Models\PriceInquiry',
            'App\Models\BuyerProfile',
            'App\Models\SupplierProfile',
        ];

        foreach ($models as $model) {
            $this->info("Importing model: {$model}");
            try {
                // Corrected: Pass $this->output instead of getVerbosity()
                Artisan::call('scout:import', ['model' => $model], $this->output);
                $this->info(Artisan::output());
            } catch (\Exception $e) {
                $this->error("Failed to import {$model}: " . $e->getMessage());
                // Optionally, decide to continue or halt on failure
                // return 1;
            }
        }

        $this->info('All models have been imported successfully.');

        return 0;
    }
}
