<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Panel;

class PanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Panel::insert([
            [ 'nombre' => 'Acanalado' , 'puede_std' => true],
            [ 'nombre' => 'Uniacanalado' , 'puede_std' => true],
            [ 'nombre' => 'Liso' , 'puede_std' => true],
            [ 'nombre' => 'Metacrilato' , 'puede_std' => false],
        ]);
    }
}
