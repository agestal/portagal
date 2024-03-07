<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::insert([
            [ 'nombre' => 'Ladrillo hueco' ],
            [ 'nombre' => 'Ladrillo relleno' ],
            [ 'nombre' => 'Bloque hueco' ],
            [ 'nombre' => 'Bloque relleno' ],
            [ 'nombre' => 'Hormigón' ],
            [ 'nombre' => 'Hierro' ],
            [ 'nombre' => 'Aluminio poco espesor' ],
            [ 'nombre' => 'Aluminio mucho espesor' ],
            [ 'nombre' => 'Pladur' ],
            [ 'nombre' => 'Cristal' ],
            [ 'nombre' => 'Poliexpan' ],
            [ 'nombre' => 'Madera' ],
            [ 'nombre' => 'Hacer Premarco' ],
            [ 'nombre' => 'Sin pilares' ],
        ]);
    }
}
