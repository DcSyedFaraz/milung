<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // products migration
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('article')->nullable();
    $table->string('status')->nullable();
    $table->string('name')->nullable();
    $table->text('description')->nullable();
    $table->string('group')->nullable();
    $table->string('cargo')->nullable();
    $table->string('cargo_place')->nullable();
    $table->string('color')->nullable();
    $table->string('material')->nullable();
    $table->string('size')->nullable();
    $table->string('weight')->nullable();
    $table->text('specification')->nullable();
    $table->string('memory')->nullable();
    $table->string('feature')->nullable();
    $table->string('accessory')->nullable();
    $table->string('accessory_weight')->nullable();
    $table->string('battery_type')->nullable();
    $table->string('rated')->nullable();
    $table->string('capacity')->nullable();
    $table->string('voltage')->nullable();
    $table->integer('pcs')->nullable();
    $table->string('mAh')->nullable();
    $table->string('mm')->nullable();
    $table->string('gram')->nullable();
    $table->string('edition')->nullable();
    $table->date('msds_expiry')->nullable();
    $table->date('un_expiry')->nullable();
    $table->string('quoteExpiredDate')->nullable();
    $table->date('air_safety_expiry')->nullable();
    $table->date('sea_safety_expiry')->nullable();
    $table->date('train_safety_expiry')->nullable();
    $table->string('certificate')->nullable();
    $table->string('printing_method')->nullable();
    $table->integer('unit_packaging_paper')->nullable();
    $table->integer('unit_packaging_plastic')->nullable();
    $table->integer('unit_packaging_metal')->nullable();
    $table->integer('unit_packaging_others')->nullable();
    $table->string('packaging_material')->nullable();
    $table->integer('packaging_weight')->nullable();
    $table->string('standart_packaging')->nullable();
    $table->string('safety_sheet')->nullable();
    $table->string('manual')->nullable();
    $table->string('product_label')->nullable();
    $table->string('packaging_label')->nullable();
    $table->string('user_id')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
