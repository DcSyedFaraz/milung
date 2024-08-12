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
        Schema::create('price_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->integer('buyer');
            $table->string('inquiry_number');
            $table->string('article');
            $table->integer('group')->nullable(); // Nullable
            $table->string('name');
            $table->text('description');
            $table->json('cargo');
            $table->json('cargo_place');
            $table->string('incoterm');
            $table->string('urgent')->default(false);
            $table->string('method');
            $table->string('color')->nullable(); // Nullable
            $table->string('packaging')->nullable(); // Nullable
            $table->text('requirements')->nullable(); // Nullable
            $table->string('status');
            $table->json('pcs');
            $table->json('supplier_ids')->nullable();
            $table->json('capacity');
            $table->string('file')->nullable();
            $table->string('file1')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_inquiries');
    }
};
