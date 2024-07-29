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
        Schema::create('puerta_tipo_motor', function (Blueprint $table) {
            $table->id();
            $table->integer('puerta_id')->references('id')->on('puertas')->constrained();
            $table->integer('tipo_motor_id')->references('id')->on('tipo_motor')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puerta_tipo_motor');
    }
};
