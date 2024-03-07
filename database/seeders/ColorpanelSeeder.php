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
            [ 'nombre' => 'ACANALADO V BLANCO 9010  ' ],
            [ 'nombre' => 'ACANALADO V CREMA 1015	' ],
            [ 'nombre' => 'ACANALADO V GRIS 9006 	' ],
            [ 'nombre' => 'ACANALADO V GRIS 7011 	' ],
            [ 'nombre' => 'ACANALADO V GRIS 7016 	' ],
            [ 'nombre' => 'ACANALADO V VERDE 6005 	' ],
            [ 'nombre' => 'ACANALADO V VERDE 6009 	' ],
            [ 'nombre' => 'ACANALADO V MARRON 8014 	' ],
            [ 'nombre' => 'ACANALADO V NEGRO 9005 	' ],
            [ 'nombre' => 'ACANALADO V ROJO 3000 	' ],
            [ 'nombre' => 'ACANALADO V AZUL 5010 	' ],
            [ 'nombre' => 'ALUMINIO ACANALADO U BLANCO 9010 	' ],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U CLARA	' ],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U OSCURA	' ],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U CLARA 	' ],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U OSCURA	' ],
            [ 'nombre' => 'UNICANAL BLANCO 9010 LISO 	' ],
            [ 'nombre' => 'UNICANAL GRIS 7016 TEXTURADO	' ],
            [ 'nombre' => 'SUPERLISO BLANCO 9010	' ],
            [ 'nombre' => 'SUPERLISO ANODIZADO INOX	' ],
            [ 'nombre' => 'SUPERLISO NEGRO TEXTURADO 9005	' ],
            [ 'nombre' => 'SUPERLISO GRIS 7016 MATE	' ],
            [ 'nombre' => 'SUPERLISO GRIS 7016 TEXTURADO	' ],
            [ 'nombre' => 'SUPERLISO MADERA OSCURA	' ],
            [ 'nombre' => 'SUPERLISO MADERA CLARA	' ],
            [ 'nombre' => 'SUPERLISO ACERO CORTEN	' ],
            [ 'nombre' => 'RAL 6045'],
            [ 'nombre' => 'RAL 7043'],
            [ 'nombre' => 'RAL 9002'],           
        ]);
    }
}
