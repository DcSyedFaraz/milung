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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->date('ship_date')->nullable();
            $table->string('ship_agent')->nullable();
            $table->string('waybill')->nullable();
            $table->string('courier')->nullable();
            $table->string('flight')->nullable();
            $table->string('vessel')->nullable();
            $table->string('train')->nullable();
            $table->date('delivery')->nullable();
            $table->string('atc_no')->nullable();
            $table->string('buyerremarks')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
