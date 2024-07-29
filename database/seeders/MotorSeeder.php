<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motor;

class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Motor::insert([
            [ 'nombre' => '1000N' , 'tipomotors_id' => 1],
            [ 'nombre' => '1500N' , 'tipomotors_id' => 1],
            [ 'nombre' => 'KVM25' , 'tipomotors_id' => 2],
            [ 'nombre' => 'INDUS 100DC' , 'tipomotors_id' => 2],

            [ 'nombre' => 'AC2000' , 'tipomotors_id' => 3],
            [ 'nombre' => 'AC5000' , 'tipomotors_id' => 3],
            [ 'nombre' => 'AC600' , 'tipomotors_id' => 4],
            [ 'nombre' => 'DC400' , 'tipomotors_id' => 4],
            [ 'nombre' => 'DC400 DE POSTE' , 'tipomotors_id' => 4],
            [ 'nombre' => 'DC500' , 'tipomotors_id' => 4],
            [ 'nombre' => 'PH270' , 'tipomotors_id' => 5],
            [ 'nombre' => 'PH270R' , 'tipomotors_id' => 5],
            [ 'nombre' => 'PH390' , 'tipomotors_id' => 5],
            [ 'nombre' => 'PH390R' , 'tipomotors_id' => 5],
            [ 'nombre' => 'SILENCE' , 'tipomotors_id' => 5],
            [ 'nombre' => 'EGO' , 'tipomotors_id' => 6],
            [ 'nombre' => 'EGO500' , 'tipomotors_id' => 6],
            [ 'nombre' => 'PM/400' , 'tipomotors_id' => 6],
            [ 'nombre' => 'PM1/400' , 'tipomotors_id' => 6],
            [ 'nombre' => '2*PH270' , 'tipomotors_id' => 7],
            [ 'nombre' => '2*PH270R' , 'tipomotors_id' => 7],
            [ 'nombre' => 'PH270 + PH270R' , 'tipomotors_id' => 7],
            [ 'nombre' => '2*PH390' , 'tipomotors_id' => 7],
            [ 'nombre' => '2*PH390R' , 'tipomotors_id' => 7],
            [ 'nombre' => 'PH390 + PH390R' , 'tipomotors_id' => 7],
            [ 'nombre' => 'PH270 + PH390R' , 'tipomotors_id' => 7],
            [ 'nombre' => 'PH270 + PH390' , 'tipomotors_id' => 7],
            [ 'nombre' => 'PH270R + PH390' , 'tipomotors_id' => 7],
            [ 'nombre' => 'PH270R + PH390R' , 'tipomotors_id' => 7],
            [ 'nombre' => 'SILENCE' , 'tipomotors_id' => 7],
            [ 'nombre' => '2*EGO' , 'tipomotors_id' => 8],
            [ 'nombre' => '2*EGO500' , 'tipomotors_id' => 8],
            [ 'nombre' => 'EGO + EGO500' , 'tipomotors_id' => 8],
            [ 'nombre' => '2*PM/400' , 'tipomotors_id' => 8],
            [ 'nombre' => '2*PM1/400' , 'tipomotors_id' => 8],
            [ 'nombre' => 'PM/400 + PM1/400' , 'tipomotors_id' => 8],

        ]);
    }
}
