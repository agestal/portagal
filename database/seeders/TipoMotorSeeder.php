<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoMotor;

class TipoMotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoMotor::insert([
            [ 'nombre' => 'Motor de techo' , 'lleva_guia' => true],
            [ 'nombre' => 'Motor de ataque a eje' , 'lleva_guia' => false],
        ]);
    }
}
