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
        Schema::create('opcions_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->integer('presupuesto_id')->references('id')->on('presupuestos')->constrained();
            $table->integer('opcion_id')->references('id')->on('opcions')->constrained();
            $table->string('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opcions_presupuestos');
    }
};
