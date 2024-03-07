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
        ]);
    }
}
