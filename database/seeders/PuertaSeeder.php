<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puerta;

class PuertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Puerta::insert([
            [ 'nombre' => 'Seccional' ],
            [ 'nombre' => 'Corredera' ],
            [ 'nombre' => 'Abatible 1 Hoja' ],
            [ 'nombre' => 'Abatible 2 Hojas' ],
            [ 'nombre' => 'Peatonal' ],
            [ 'nombre' => 'Persiana' ],
            [ 'nombre' => 'Lona' ],
            [ 'nombre' => 'Cristal' ],
            [ 'nombre' => 'Cierre finca' ],
        ]);
    }
}
