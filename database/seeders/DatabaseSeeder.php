<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PuertaSeeder::class);
        $this->call(PanelSeeder::class);
        $this->call(ColorpanelSeeder::class);
        $this->call(OpcionSeeder::class);
        $this->call(TipoMotorSeeder::class);
        $this->call(MotorSeeder::class);
        $this->call(PuertamaterialSeeder::class);
        $this->call(MaterialSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
