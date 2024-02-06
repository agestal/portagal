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
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->date('fecha');
            $table->integer('diseno_id')->nullable();
            $table->integer('pano_id')->nullable();
            $table->integer('opcion_id')->nullable();
            $table->integer('apertura_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->dropColumn('diseno_id');
            $table->dropColumn('pano_id');
            $table->dropColumn('opcion_id');
            $table->dropColumn('apertura_id');
        });
    }
};
