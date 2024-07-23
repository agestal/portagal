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
            [ 'nombre' => 'ACANALADO V BLANCO 9010  '               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V CREMA 1015	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V GRIS 9006 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V GRIS 7011 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V GRIS 7016 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V VERDE 6005 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V VERDE 6009 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V MARRON 8014 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V NEGRO 9005 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V ROJO 3000 	'               , 'std' => 1],
            [ 'nombre' => 'ACANALADO V AZUL 5010 	'               , 'std' => 1],
            [ 'nombre' => 'ALUMINIO ACANALADO U BLANCO 9010 	'   , 'std' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U CLARA	'   , 'std' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U OSCURA	'   , 'std' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U CLARA 	'   , 'std' => 1],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U OSCURA	'   , 'std' => 1],
            [ 'nombre' => 'UNICANAL BLANCO 9010 LISO 	'           , 'std' => 1],
            [ 'nombre' => 'UNICANAL GRIS 7016 TEXTURADO	'           , 'std' => 1],
            [ 'nombre' => 'SUPERLISO BLANCO 9010	'               , 'std' => 1],
            [ 'nombre' => 'SUPERLISO ANODIZADO INOX	'               , 'std' => 1],
            [ 'nombre' => 'SUPERLISO NEGRO TEXTURADO 9005	'       , 'std' => 1],
            [ 'nombre' => 'SUPERLISO GRIS 7016 MATE	'               , 'std' => 1],
            [ 'nombre' => 'SUPERLISO GRIS 7016 TEXTURADO	'       , 'std' => 1],
            [ 'nombre' => 'SUPERLISO MADERA OSCURA	'               , 'std' => 1],
            [ 'nombre' => 'SUPERLISO MADERA CLARA	'               , 'std' => 1],
            [ 'nombre' => 'SUPERLISO ACERO CORTEN	'               , 'std' => 1],
            [ 'nombre' => 'RAL 6045'                                , 'std' => 0],
            [ 'nombre' => 'RAL 7043'                                , 'std' => 0],
            [ 'nombre' => 'RAL 9002'                                , 'std' => 0],
        ]);
    }
}
