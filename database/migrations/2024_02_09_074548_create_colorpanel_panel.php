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
        Schema::create('colorpanel_panel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panel_id')->references('id')->on('panels')->constrained();
            $table->foreignId('colorpanel_id')->references('id')->on('colorpanels')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colorpanel_panel');
    }
};
