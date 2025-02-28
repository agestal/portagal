<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Elevador;

class ElevadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Elevador::insert([
             [ 'nombre' => 'Tijera electrica 10m' ],
             [ 'nombre' => 'Tijera electrica 12m' ],
             [ 'nombre' => 'Tijera Diesel pequeña' ],
             [ 'nombre' => 'Tijera Diesel grande' ],
             [ 'nombre' => 'Pato 12m.' ],
             [ 'nombre' => 'Camión cesta' ],
             [ 'nombre' => 'Andamio' ],
        ]);
    }
}