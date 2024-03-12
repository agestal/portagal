<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puertamaterial;

class PuertamaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Puertamaterial::insert([
            [ 'nombre' => 'Aluminio' ],
            [ 'nombre' => 'Acero galvanizado' ],
            [ 'nombre' => 'Panel sandwich' ],
        ]);
    }
}
