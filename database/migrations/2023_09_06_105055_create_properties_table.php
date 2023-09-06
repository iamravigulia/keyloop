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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->text('description');
            $table->string('displayableAddress');
            $table->string('image');
            $table->string('thumnail');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('num_bedrooms')->index();
            $table->integer('num_bathrooms');
            $table->integer('price')->index();
            $table->foreignId('property_type_id');
            $table->enum('type', ['rent', 'sale'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
