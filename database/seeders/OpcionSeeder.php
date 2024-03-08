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
            [ 'nombre' => 'Fotocélulas espejo' ], 
            [ 'nombre' => 'Fotocélulas emisor receptor' ],
            [ 'nombre' => 'Desbloqueo exterior' ],
            [ 'nombre' => 'Teclado inalámbrico' ],
            [ 'nombre' => 'Seguridad peatonal' ],
            [ 'nombre' => 'Mandos inox' ],
            [ 'nombre' => 'Led' ],
            [ 'nombre' => 'Banda de seguridad' ],
            [ 'nombre' => 'Pulsador inalámbrico' ],
            [ 'nombre' => 'Pulsador cableado' ],
            [ 'nombre' => 'Receptor externo' ],
            [ 'nombre' => 'Antena exterior' ],
        ]);
    }
}






