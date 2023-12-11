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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cust_id')->constrained('customers', 'id')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars', 'id');
            $table->string('start_date');
            $table->string('end_date');
            $table->decimal('totalCost', 10, 2); // Adjust precision and scale as needed
            $table->string('status')->default('Pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
