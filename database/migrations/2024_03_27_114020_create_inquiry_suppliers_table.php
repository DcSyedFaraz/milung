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
        Schema::create('inquiry_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_inquiry_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('supplier_profiles')->onDelete('cascade');
            $table->string('quantity');
            $table->string('capacity');
            $table->integer('exw')->nullable();
            $table->boolean('selected')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_suppliers');
    }
};
