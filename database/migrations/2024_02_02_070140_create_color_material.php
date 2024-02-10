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
        Schema::create('color_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->references('id')->on('materials')->constrained();
            $table->foreignId('color_id')->references('id')->on('colors')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_material');
    }
};
