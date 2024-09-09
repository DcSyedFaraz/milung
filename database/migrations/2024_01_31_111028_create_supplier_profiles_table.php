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
        Schema::create('supplier_profiles', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('supplier_id')->unique();
            $table->string('status')->default('active');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('website');
            $table->string('office_phone')->nullable();
            $table->string('supplier_description');
            $table->json('group');
            $table->json('sec_group');
            $table->string('company_header')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('chips_no')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('account_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_profiles');
    }
};
