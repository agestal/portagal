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

            $table->date('fecha'); /***/
            $table->string('nombre_cliente'); /***/
            $table->string('email'); /***/
            $table->string('referencia'); /***/

            $table->foreignId('puerta_id')->references('id')->on('puertas')->nullable();/***/

            $table->foreignId('puertamaterial_id')->nullable();

            $table->foreignId('panel_id')->nullable();/***/
            $table->foreignId('colorpanel_id')->nullable();/***/
            $table->boolean('tipo_color_panel')->nullable();  /***/
            $table->string('colorpanel_no_std')->nullable(); /***/

            $table->integer('tipo_suelo')->nullable();/***/
            $table->float('suelocc_altod')->nullable();/***/
            $table->float('suelocc_altoi')->nullable();/***/
            $table->float('suelocc_ancho')->nullable();/***/
            $table->float('suelocc_dintel')->nullable();/***/
            $table->float('sueloh_alto')->nullable();/***/
            $table->float('sueloh_ancho')->nullable();/***/
            $table->float('sueloh_dintel')->nullable();/***/
            $table->boolean('techo_inclinacion')->nullable();
            $table->float('grados_inclinacion')->nullable(); /***/

            $table->float('pilares_alto')->nullable();/***/
            $table->float('pilares_ancho')->nullable();/***/

            $table->boolean('buzon')->nullable(); /***/
            $table->integer('tipo_buzon')->nullable(); /***/

            $table->boolean('bate_contrau')->nullable();
            $table->integer('opcion_contrau')->nullable();

            $table->integer('orientacion')->nullable();

            $table->boolean('guia_suelo')->nullable();
            $table->integer('tipo_guia_suelo')->nullable();
            $table->integer('material_guia_suelo')->nullable();

            $table->boolean('orejetas')->nullable();
            $table->string('orejetas_medidas')->nullable();
            $table->text('orejetas_dibujo')->nullable();

            $table->boolean('dintel_panel')->nullable(); /***/
            $table->string('dintel_ancho')->nullable(); /***/
            $table->string('dintel_alto')->nullable(); /***/

            $table->boolean('tubos_laterales')->nullable(); /***/
            $table->integer('tubos_cantidad')->nullable(); /***/
            $table->string('tubos_alto')->nullable(); /***/
            $table->string('tubos_color')->nullable(); /***/

            $table->boolean('ventanas')->nullable(); /***/
            $table->integer('ventanas_tipo')->nullable();
            $table->integer('ventanas_tipo_cristal')->nullable();
            $table->integer('numero_ventanas')->nullable(); /***/
            $table->text('posicion_ventanas')->nullable(); /***/

            $table->boolean('rejillas')->nullable();  /***/
            $table->integer('numero_rejillas')->nullable();  /***/
            $table->text('posicion_rejillas')->nullable();  /***/

            $table->boolean('muelles_antirotura')->default(true); /***/
            $table->integer('color_herraje_std')->nullable(); /***/
            $table->string('color_herraje_no_std')->nullable(); /***/

            $table->boolean('soporte_guia_lateral')->default(true); /***/
            $table->integer('color_guias_std')->nullable(); /***/
            $table->string('color_guias_no_std')->nullable(); /***/
            $table->boolean('paracaidas')->nullable(); /***/

            $table->boolean('peatonal_insertada')->nullable();
            $table->integer('peatonal_apertura')->nullable();
            $table->integer('peatonal_posicion')->nullable();
            $table->integer('peatonal_bisagras')->nullable();
            $table->boolean('peatonal_cierrapuertas')->nullable();
            $table->boolean('peatonal_seguridad')->nullable();

            $table->string('funcionamiento')->nullable();
            $table->integer('tipomotors_id')->nullable();
            $table->integer('motors_id')->nullable();

            $table->string('manual_cerradura')->nullable();
            $table->string('manual_tirador')->nullable();

            $table->boolean('electricidad')->nullable();
            $table->text('electricidad_comentarios')->nullable();
            $table->boolean('obras')->nullable();
            $table->text('obras_comentarios')->nullable();
            $table->integer('distancia_vertical')->nullable();
            $table->integer('distancia_horizontal')->nullable();
            $table->integer('elevador')->nullable();
            $table->integer('elevador_portagal')->nullable();
            $table->integer('materiales_pilares')->nullable();
            $table->integer('materiales_techo')->nullable();

            $table->text('firma')->nullable();
            $table->text('montaje_guias')->nullable();
            $table->text('renates')->nullable();
            $table->text('portico')->nullable();

            $table->text('fotos')->nullable();
            $table->text('comentarios_fotos')->nullable();

            $table->text('comentarios')->nullable();

            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->string('location')->nullable();
            $table->string('full_address')->nullable();

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
