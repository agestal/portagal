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
            $table->integer('material_id')->references('id')->on('materiales');
            $table->integer('color_id')->references('id')->on('color');
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
