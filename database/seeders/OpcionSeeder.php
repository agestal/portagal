<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opcion;

class OpcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Opcion::insert([
            [ 'nombre' => 'Herrajes' ], 
            [ 'nombre' => 'Guia' ],
            [ 'nombre' => 'Soporte directo guia lateral' ],
            [ 'nombre' => 'Anti rotura de muelles' ],
            [ 'nombre' => 'Paracaidas' ],
        ]);
    }
}
