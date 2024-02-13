<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Funcionamiento;

class FuncionamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Funcionamiento::insert([
            [ 'nombre' => 'Tirador manual' , 'automatico' => false],
            [ 'nombre' => 'Cerradura lat. FAC' , 'automatico' => false],
            [ 'nombre' => 'Desbloqueo exterior' , 'automatico' => true],
            [ 'nombre' => 'Motor' , 'automatico' => true],
            [ 'nombre' => 'Pulsador inalámbrico' , 'automatico' => true],
            [ 'nombre' => 'Pulsador cableado' , 'automatico' => true],
            [ 'nombre' => 'Tirador automático' , 'automatico' => true],
            [ 'nombre' => 'Banda seguridad' , 'automatico' => true],
            [ 'nombre' => 'Fotocélulas' , 'automatico' => true],
            [ 'nombre' => 'Receptor externo' , 'automatico' => true],
            [ 'nombre' => 'Mandos' , 'automatico' => true],
        ]);
    }
}
