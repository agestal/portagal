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
        Schema::create('materials_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->references('id')->on('colors')->constrained()->nullable();
            $table->foreignId('presupuesto_id')->references('id')->on('colors')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_presupuestos');
    }
};
