<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice')->nullable();
            $table->decimal('totalpayable', 10, 2)->nullable();
            $table->string('party')->nullable();
            $table->string('loading')->nullable();
            $table->string('destination')->nullable();
            $table->string('payment')->nullable();
            $table->string('courier')->nullable();
            $table->string('tracking')->nullable();
            $table->integer('extra')->nullable();
            $table->string('shipper')->nullable();
            $table->string('consignee')->nullable();
            $table->string('carton')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
