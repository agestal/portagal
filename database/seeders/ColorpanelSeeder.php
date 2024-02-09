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
            [ 'nombre' => 'ACANALADO V BLANCO 9010  ' , 'std' => true],
            [ 'nombre' => 'ACANALADO V CREMA 1015	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V GRIS 9006 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V GRIS 7011 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V GRIS 7016 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V VERDE 6005 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V VERDE 6009 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V MARRON 8014 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V NEGRO 9005 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V ROJO 3000 	' , 'std' => true],
            [ 'nombre' => 'ACANALADO V AZUL 5010 	' , 'std' => true],
            [ 'nombre' => 'ALUMINIO ACANALADO U BLANCO 9010 	' , 'std' => true],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U CLARA	' , 'std' => true],
            [ 'nombre' => 'IMITACIÓN MADERA ACANALADA U OSCURA	' , 'std' => true],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U CLARA 	' , 'std' => true],
            [ 'nombre' => 'IMITACIÓN MADERA UNICANAL U OSCURA	' , 'std' => true],
            [ 'nombre' => 'UNICANAL BLANCO 9010 LISO 	' , 'std' => true],
            [ 'nombre' => 'UNICANAL GRIS 7016 TEXTURADO	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO BLANCO 9010	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO ANODIZADO INOX	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO NEGRO TEXTURADO 9005	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO GRIS 7016 MATE	' , 'std' =>true],
            [ 'nombre' => 'SUPERLISO GRIS 7016 TEXTURADO	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO MADERA OSCURA	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO MADERA CLARA	' , 'std' => true],
            [ 'nombre' => 'SUPERLISO ACERO CORTEN	' , 'std' => true],
            [ 'nombre' => 'RAL 6045' , 'std' => false],
            [ 'nombre' => 'RAL 7043' , 'std' => false],
            [ 'nombre' => 'RAL 9002' , 'std' => false],           
        ]);
    }
}
