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
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('nombre_cliente');
            $table->string('email');
            $table->string('pedido');
            $table->foreignId('puerta_id')->references('id')->on('puertas')->nullable();
            $table->foreignId('panel_id')->references('id')->on('panels')->nullable();
            $table->foreignId('colorpanel_id')->references('id')->on('colorpanels')->nullable();
           
            $table->string('archivo1');
            $table->string('firma');
            $table->foreignId('material_id')->references('id')->on('materials')->nullable();
            $table->foreignId('color_id')->references('id')->on('colors')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
