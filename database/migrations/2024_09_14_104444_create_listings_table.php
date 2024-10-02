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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('property_type')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('garages')->nullable();
            $table->decimal('land_size', 10, 2)->nullable();
            $table->decimal('house_size', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_per_sqft', 10, 2)->nullable();
            $table->string('address')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('real_estate_agent')->nullable();
            $table->boolean('is_negotiable')->default(false);
            $table->boolean('is_for_sale')->default(true);
            $table->boolean('is_for_rent')->default(false);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
