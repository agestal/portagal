<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colorpanel;

class ColorpanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Colorpanel::insert([
            [ 'nombre' => 'ACANALADO V BLANCO 9010  '               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V CREMA 1015	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V GRIS 9006 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V GRIS 7011 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V GRIS 7016 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V VERDE 6005 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V VERDE 6009 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V MARRON 8014 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V NEGRO 9005 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V ROJO 3000 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ACANALADO V AZUL 5010 	'               , 'panels_id' => 1],
            [ 'nombre' => 'ALUMINIO ACANALADO U BLANCO 9010 	'   , 'panels_id' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U CLARA	'   , 'panels_id' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U OSCURA	'   , 'panels_id' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U CLARA 	'   , 'panels_id' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U OSCURA	'   , 'panels_id' => 1],

            [ 'nombre' => 'UNICANAL BLANCO 9010 LISO 	'           , 'panels_id' => 2],
            [ 'nombre' => 'UNICANAL GRIS 7016 TEXTURADO	'           , 'panels_id' => 2],
            [ 'nombre' => 'UNICANAL IMITACIÓN MADERA CLARA'         , 'panels_id' => 2],
            [ 'nombre' => 'UNICANAL IMITACIÓN MADERA OSCURA'        , 'panels_id' => 2],

            [ 'nombre' => 'SUPERLISO BLANCO 9010	'               , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO ANODIZADO INOX	'               , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO NEGRO TEXTURADO 9005	'       , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO GRIS 7016 MATE	'               , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO GRIS 7016 TEXTURADO	'       , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO MADERA OSCURA	'               , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO MADERA CLARA	'               , 'panels_id' => 3],
            [ 'nombre' => 'SUPERLISO ACERO CORTEN	'               , 'panels_id' => 3],

            [ 'nombre' => 'CUARTERÓN BLANCO 9010	'               , 'panels_id' => 4],
        ]);
    }
}
