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
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('supplier_profiles')->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->decimal('total_value', 8, 2);
            $table->string('settle_amount')->nullable();
            $table->string('incoterm')->nullable();
            $table->string('settle_date')->nullable();
            $table->string('outstanding_amount')->nullable();
            $table->string('status')->nullable();
            $table->string('slip')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};
