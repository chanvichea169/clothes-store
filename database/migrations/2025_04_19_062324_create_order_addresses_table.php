<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            // Address type: shipping or billing
            $table->enum('type', ['shipping', 'billing'])->default('shipping');

            // Contact information
            $table->string('name');
            $table->string('email');
            $table->string('phone');

            // Address details
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code');

            // Additional fields if needed
            $table->string('company')->nullable();
            $table->string('address_line2')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('order_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('order_addresses');
    }
};
