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
        Schema::table('users', function (Blueprint $table) {
            // Remove the soft deletes column
            $table->dropSoftDeletes();

            // Add the contact number column
            $table->string('contact_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the soft deletes column
            $table->softDeletes();

            // Remove the contact number column
            $table->dropColumn('contact_number');
        });

    }
};
