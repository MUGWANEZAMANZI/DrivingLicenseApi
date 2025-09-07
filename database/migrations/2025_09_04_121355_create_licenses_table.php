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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->integer('driverId')->constrained('id')->onDelete('cascade');
            $table->string('licenseNumber')->unique();
            $table->date('issueDate');
            $table->date('expiryDate');
            $table->string('plateNumber')->unique();
            $table->string('dateLieuDelivrance')->nullable(); // Place of issue
            $table->string('licensesAllowed')->nullable(); // Allowed licenses (text)
            $table->string('allowedCategories')->nullable(); // Allowed categories (comma separated or JSON)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
