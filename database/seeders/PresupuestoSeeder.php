<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Presupuesto;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Presupuesto::insert([
            'puerta_id' => 1,
            'material_id' => 1,
            'color_id' => 1,
        ]);
    }
}
