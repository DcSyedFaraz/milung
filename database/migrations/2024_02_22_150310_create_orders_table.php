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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('linked_order')->nullable();
            $table->foreign('linked_order')->references('id')->on('orders')->onDelete('cascade');
            $table->string('accessories')->nullable();
            $table->string('article')->nullable();
            $table->string('atc_number')->nullable();
            $table->string('capacity')->nullable();
            $table->string('buyeremail')->nullable();
            $table->string('buyerorder')->nullable();
            $table->string('ftyitem')->nullable();
            $table->json('logocolor')->nullable();
            $table->integer('group')->nullable();
            $table->string('incoterm')->nullable();
            $table->string('inquiry')->nullable();
            $table->string('milungorder')->nullable();
            $table->string('notice')->nullable()->default('[]');
            $table->date('orderdate')->nullable();
            $table->string('orderremarks')->nullable();
            $table->string('packaging')->nullable();
            $table->string('packagingprinting')->nullable();
            $table->string('printingmethod')->nullable();
            $table->string('productcolor')->nullable();
            $table->string('productname')->nullable();
            $table->string('qcremarks')->nullable();
            $table->string('quantity_unit')->nullable();
            $table->string('reference')->nullable();
            $table->json('logoFiles')->nullable();
            $table->json('manualFiles')->nullable();
            $table->json('safetySheetFiles')->nullable();
            $table->json('labelFiles')->nullable();
            $table->json('files')->nullable();
            $table->date('sendoutdate')->nullable();
            $table->string('ship_doc')->nullable();
            $table->integer('so_number')->nullable();
            $table->string('status')->nullable();
            $table->integer('buyer')->nullable();
            $table->integer('supplier')->nullable();
            $table->decimal('sellingprice', 10, 2)->nullable();
            $table->decimal('buyingprice', 10, 2)->nullable();
            $table->decimal('totalvalue', 10, 2)->nullable();
            $table->string('assigned_to_supplier_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
