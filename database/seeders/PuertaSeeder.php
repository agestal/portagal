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
            [ 'nombre' => 'Seccional' , 'automatica' => true , 'permite_motor' => true],
            [ 'nombre' => 'Corredera' , 'automatica' => true , 'permite_motor' => true],
            [ 'nombre' => 'Abatible 1 Hoja' , 'automatica' => false , 'permite_motor' => false ],
            [ 'nombre' => 'Abatible 2 Hojas' , 'automatica' => false , 'permite_motor' => false ],
            [ 'nombre' => 'Peatonal' , 'automatica' => false , 'permite_motor' => false],
            [ 'nombre' => 'Persiana' , 'automatica' => true , 'permite_motor' => true],
            [ 'nombre' => 'Lona' , 'automatica' => false , 'permite_motor' => false],
            [ 'nombre' => 'Cristal' , 'automatica' => true , 'permite_motor' => true],
            [ 'nombre' => 'Cierre finca' , 'automatica' => false , 'permite_motor' => false],
        ]);
    }
}
