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

            /* Datos principales */
            $table->date('fecha');
            $table->string('nombre_cliente');
            $table->string('email');
            $table->string('referencia');

            /* Relaciones básicas */
            $table->foreignId('puerta_id')->nullable()->constrained();
            $table->foreignId('puertamaterial_id')->nullable()->constrained();
            $table->foreignId('panel_id')->nullable()->constrained();
            $table->foreignId('colorpanel_id')->nullable()->constrained();

            /* Panel y color */
            $table->boolean('tipo_color_panel')->nullable();
            $table->string('colorpanel_no_std')->nullable();

            /* Suelo y techo */
            $table->tinyInteger('tipo_suelo')->nullable();
            $table->float('suelocc_altod')->nullable();
            $table->float('suelocc_altoi')->nullable();
            $table->float('suelocc_ancho')->nullable();
            $table->float('suelocc_dintel')->nullable();
            $table->float('sueloh_alto')->nullable();
            $table->float('sueloh_ancho')->nullable();
            $table->float('sueloh_dintel')->nullable();
            $table->boolean('techo_inclinacion')->nullable();
            $table->float('grados_inclinacion')->nullable();

            /* Opciones de paño */
            $table->tinyInteger('opciones_pano')->nullable();
            $table->string('color_pano')->nullable();
            $table->string('diseno_especial')->nullable();
            $table->string('color_panel_sandwich')->nullable();

            /* Opciones de dintel */
            $table->float('dintel_ancho')->nullable();
            $table->float('dintel_alto')->nullable();
            $table->tinyInteger('modelo_dintel')->nullable();
            $table->string('descripcion_modelo_dintel')->nullable();

            /* Medidas generales */
            $table->float('pilar_izquierdo')->nullable();
            $table->float('pilar_derecho')->nullable();
            $table->float('ancho_plibre')->nullable();
            $table->float('ancho_hueco')->nullable();
            $table->float('puerta_izquierda_ext')->nullable();
            $table->float('puerta_derecha_ext')->nullable();
            $table->float('puerta_izquierda_int')->nullable();
            $table->float('puerta_derecha_int')->nullable();
            $table->tinyInteger('direccion_apertura')->nullable();

            $table->integer('solape_motor')->nullable();
            $table->integer('solape_cierra')->nullable();

            /* Rabos y caída */
            $table->boolean('rabos')->nullable();
            $table->float('rabo_superior')->nullable();
            $table->float('rabo_inferior')->nullable();
            $table->boolean('puerta_caida')->nullable();
            $table->tinyInteger('opciones_caida')->nullable();
            $table->mediumText('caida_dibujo')->nullable();

            /* Guías y cierres */
            $table->tinyInteger('tipo_guia')->nullable();               // ⬅️ añadido
            $table->integer('medida_dintel')->nullable();
            $table->tinyInteger('tipo_cierre')->nullable();
            $table->tinyInteger('rueda')->nullable();
            $table->string('descripcion_rueda')->nullable();
            $table->boolean('guia_suelo')->nullable();
            $table->tinyInteger('tipo_guia_suelo')->nullable();
            $table->tinyInteger('material_guia_suelo')->nullable();
            $table->float('holgura_inferior')->nullable();
            $table->tinyInteger('tipo_cierre_peatonal')->nullable();

            /* Peatonal insertada */
            $table->boolean('pano_fijo_hoja_aux')->nullable();
            $table->integer('ancho_fijo_aux')->nullable();
            $table->integer('alto_fijo_aux')->nullable();
            $table->tinyInteger('configuracion_hoja_aux')->nullable();  // ⬅️ añadido

            /* Buzón y rejillas */
            $table->boolean('buzon')->nullable();
            $table->tinyInteger('buzon_tipo')->nullable();              // ⬅️ nuevo nombre usado en el form
            $table->tinyInteger('tipo_buzon')->nullable();              // ↔️ nombre antiguo (se mantiene)
            $table->mediumText('ubicacion_buzon')->nullable();

            $table->boolean('rejillas')->nullable();
            $table->tinyInteger('rejillas_tipo')->nullable();           // ⬅️ añadido
            $table->integer('numero_rejillas')->nullable();
            $table->text('posicion_rejillas')->nullable();

            /* Ventanas */
            $table->boolean('ventanas')->nullable();
            $table->tinyInteger('ventana_tipo')->nullable();            // ⬅️ añadido
            $table->tinyInteger('ventana_tipo_cristal')->nullable();    // ⬅️ añadido
            $table->tinyInteger('ventanas_tipo')->nullable();           // nombre antiguo
            $table->tinyInteger('ventanas_tipo_cristal')->nullable();
            $table->integer('numero_ventanas')->nullable();
            $table->text('posicion_ventanas')->nullable();

            /* Herrajes y colores */
            $table->boolean('muelles_antirotura')->default(true);
            $table->tinyInteger('color_herraje_std')->nullable();
            $table->string('color_herraje_no_std')->nullable();
            $table->boolean('soporte_guia_lateral')->default(true);
            $table->tinyInteger('color_guias_std')->nullable();
            $table->string('color_guias_no_std')->nullable();
            $table->boolean('paracaidas')->nullable();

            /* Peatonal */
            $table->boolean('peatonal_insertada')->nullable();
            $table->tinyInteger('peatonal_apertura')->nullable();
            $table->tinyInteger('peatonal_posicion')->nullable();
            $table->tinyInteger('peatonal_bisagras')->nullable();
            $table->tinyInteger('peatonal_umbral')->nullable();         // ⬅️ añadido
            $table->tinyInteger('peatonal_cerradura')->nullable();      // ⬅️ añadido
            $table->boolean('peatonal_cierrapuertas')->nullable();
            $table->boolean('peatonal_seguridad')->nullable();
            $table->text('observaciones_peatonal_ins')->nullable();
            $table->mediumText('dibujo_peatonal')->nullable();

            /* Funcionamiento y motor */
            $table->tinyInteger('funcionamiento')->nullable();
            $table->tinyInteger('motor_opcion')->nullable();
            $table->foreignId('tipomotors_id')->nullable()->constrained('tipo_motor');
            $table->foreignId('motors_id')->nullable()->constrained('motors');
            $table->json('mecanismo_cierra')->nullable();
            $table->boolean('cisa_moderna')->nullable();                // ⬅️ añadido

            /* Manual */
            $table->boolean('manual_cerradura_fac')->nullable();
            $table->json('manual_cerradura_pc')->nullable();
            $table->boolean('manual_tirador')->nullable();
            $table->tinyInteger('manillas')->nullable();
            $table->tinyInteger('manillas_peatonal')->nullable();
            $table->boolean('tirador')->nullable();
            $table->tinyInteger('tipo_tirador')->nullable();

            /* Montaje y obra */
            $table->boolean('electricidad')->nullable();
            $table->tinyInteger('responsable_elect')->nullable();       // ⬅️ añadido
            $table->text('electricidad_comentarios')->nullable();
            $table->boolean('obras')->nullable();
            $table->tinyInteger('responsable_obras')->nullable();       // ⬅️ añadido
            $table->text('obras_comentarios')->nullable();
            $table->integer('distancia_vertical')->nullable();
            $table->integer('distancia_horizontal')->nullable();
            $table->boolean('elevador')->nullable();
            $table->tinyInteger('responsable_elevador')->nullable();    // ⬅️ añadido
            $table->foreignId('elevadors_id')->nullable()->constrained('elevadors'); // ⬅️ añadido
            $table->tinyInteger('elevador_portagal')->nullable();

            /* Materiales (obra) */
            $table->foreignId('materiales_pilar_izquierdo')->nullable(); // ⬅️ añadido
            $table->foreignId('materiales_pilar_derecho')->nullable();   // ⬅️ añadido
            $table->foreignId('materiales_techo_anclaje')->nullable();   // ⬅️ añadido
            $table->integer('materiales_pilares')->nullable();   // legacy
            $table->integer('materiales_techo')->nullable();     // legacy
            $table->boolean('montaje_guia_suelo')->nullable();
            $table->integer('material_guia_suelo_cr')->nullable();
            $table->text('materiales_comentarios')->nullable();

            /* Tubos */
            $table->integer('tubos_cantidad')->nullable();
            $table->float('tubos_alto')->nullable();
            $table->string('tubos_color')->nullable();


            /* Otros */
            $table->tinyInteger('tipo_vivienda')->nullable();
            $table->float('ancho_pilares')->nullable();
            $table->boolean('cerrojo_suelo')->nullable();

            /* Dibujos / Croquis (mediumText) */
            $table->mediumText('firma')->nullable();
            $table->mediumText('croquis_1')->nullable();
            $table->mediumText('croquis_2')->nullable();
            $table->mediumText('batiente_1')->nullable();
            $table->mediumText('batiente_2')->nullable();
            $table->mediumText('orejetas_1')->nullable();
            $table->mediumText('remate_1')->nullable();
            $table->mediumText('remate_2')->nullable();
            $table->mediumText('poste_1')->nullable();
            $table->mediumText('poste_2')->nullable();
            $table->mediumText('poste_3')->nullable();
            $table->mediumText('u_de_cierre')->nullable();
            $table->mediumText('portico')->nullable();
            $table->mediumText('tope_suelo')->nullable();

            /* Switches de visibilidad de los dibujos */
            $table->boolean('sw_croquis_1')->nullable();
            $table->boolean('sw_croquis_2')->nullable();
            $table->boolean('sw_batiente_1')->nullable();
            $table->boolean('sw_batiente_2')->nullable();
            $table->boolean('sw_orejetas')->nullable();
            $table->boolean('sw_remate_1')->nullable();
            $table->boolean('sw_remate_2')->nullable();
            $table->boolean('sw_poste_1')->nullable();
            $table->boolean('sw_poste_2')->nullable();
            $table->boolean('sw_poste_3')->nullable();
            $table->boolean('sw_u_de_cierre')->nullable();
            $table->boolean('sw_portico')->nullable();
            $table->boolean('sw_tope_suelo')->nullable();

            /* Fotografías */
            $table->mediumText('fotos')->nullable();
            $table->text('comentarios_fotos')->nullable();

            /* Coordenadas y dirección */
            $table->double('lat', 10, 7)->nullable();
            $table->double('lon', 10, 7)->nullable();
            $table->string('location')->nullable();
            $table->string('full_address')->nullable();

            /* Medidas de obra adicionales */
            $table->integer('distancia_paredes')->nullable();
            $table->integer('altura_hasta_techo')->nullable();          // ⬅️ añadido

            /* Comentarios libres */
            $table->text('comentarios')->nullable();

            /* Timestamps */
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
