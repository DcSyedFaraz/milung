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
        Schema::create('packing_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipment_order_id')->constrained()->onDelete('cascade');
            $table->string('carton')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('totalqty')->nullable();
            $table->decimal('nw')->nullable();
            $table->decimal('totalnw')->nullable();
            $table->decimal('gw')->nullable();
            $table->decimal('totalgw')->nullable();
            $table->decimal('lcm')->nullable();
            $table->decimal('wcm')->nullable();
            $table->decimal('hcm')->nullable();
            $table->decimal('totalVolume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_lists');
    }
};
