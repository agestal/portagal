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
            [ 'nombre' => 'Corredera' ] , [ 'nombre' => 'Fija' ]
        ]);
    }
}
