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
        Schema::create('product_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name')->unique();
            $table->string('description')->nullable();
            $table->integer('profit')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('hs_de');
            $table->integer('hs_cn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_groups');
    }
};
