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
        Schema::create('settle_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('information_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipment_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('settle_amount')->nullable();
            $table->string('settle_date')->nullable();
            $table->string('outstanding_amount')->nullable();
            $table->string('status')->nullable();
            $table->string('slip')->nullable();
            $table->string('remarks')->nullable();
            $table->string('admin_slip')->nullable();
            $table->string('admin_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settle_amounts');
    }
};
