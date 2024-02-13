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
        Schema::create('funcionamiento_presupuesto', function (Blueprint $table) {
            $table->id();
            $table->integer('presupuesto_id')->references('id')->on('presupuestos')->constrained();
            $table->integer('funcionamiento_id')->references('id')->on('funcionamientos')->constrained();
            $table->string('valor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionamiento_presupuesto');
    }
};
