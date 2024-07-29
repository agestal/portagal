<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PuertaTipoMotor;

class PuertaTipoMotorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PuertaTipoMotor::insert([
            ['puerta_id' => 1, 'tipo_motor_id' => 1 ],
            ['puerta_id' => 1, 'tipo_motor_id' => 2 ],
            ['puerta_id' => 2, 'tipo_motor_id' => 3 ],
            ['puerta_id' => 2, 'tipo_motor_id' => 4 ],
            ['puerta_id' => 3, 'tipo_motor_id' => 5 ],
            ['puerta_id' => 3, 'tipo_motor_id' => 6 ],
            ['puerta_id' => 4, 'tipo_motor_id' => 7 ],
            ['puerta_id' => 4, 'tipo_motor_id' => 8 ],
        ]);
    }
}
