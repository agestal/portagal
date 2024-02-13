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
            $table->foreignId('opcion_id')->references('id')->on('opcions')->nullable();
            $table->string('archivo1',1000)->nullable();
            $table->string('firma',1000)->nullable();
            $table->boolean('electricidad')->nullable();
            $table->boolean('obras')->nullable();
            $table->boolean('elevador')->nullable();
            $table->integer('distancia_vertical')->nullable();
            $table->integer('distancia_horizontal')->nullable();
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
