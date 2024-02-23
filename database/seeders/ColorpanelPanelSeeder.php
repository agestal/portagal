<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ColorpanelPanel;


class ColorpanelPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ColorpanelPanel::insert([
            [ 'panel_id' => 1 , 'colorpanel_id' => 11],
            [ 'panel_id' => 1 , 'colorpanel_id' => 1],
            [ 'panel_id' => 1 , 'colorpanel_id' => 2],
            [ 'panel_id' => 1 , 'colorpanel_id' => 4],
            [ 'panel_id' => 1 , 'colorpanel_id' => 5],
            [ 'panel_id' => 1 , 'colorpanel_id' => 3],
            [ 'panel_id' => 1 , 'colorpanel_id' => 8],
            [ 'panel_id' => 1 , 'colorpanel_id' => 9],
            [ 'panel_id' => 1 , 'colorpanel_id' => 10],
            [ 'panel_id' => 1 , 'colorpanel_id' => 6],
            [ 'panel_id' => 1 , 'colorpanel_id' => 7],
            [ 'panel_id' => 1 , 'colorpanel_id' => 12],
            [ 'panel_id' => 1 , 'colorpanel_id' => 13],
            [ 'panel_id' => 1 , 'colorpanel_id' => 14],
            [ 'panel_id' => 2 , 'colorpanel_id' => 17],
            [ 'panel_id' => 2 , 'colorpanel_id' => 18],
            [ 'panel_id' => 2 , 'colorpanel_id' => 15],
            [ 'panel_id' => 2 , 'colorpanel_id' => 16],
            [ 'panel_id' => 3 , 'colorpanel_id' => 26],
            [ 'panel_id' => 3 , 'colorpanel_id' => 21],
            [ 'panel_id' => 3 , 'colorpanel_id' => 24],
            [ 'panel_id' => 3 , 'colorpanel_id' => 19],
            [ 'panel_id' => 3 , 'colorpanel_id' => 20],
            [ 'panel_id' => 3 , 'colorpanel_id' => 22],
            [ 'panel_id' => 3 , 'colorpanel_id' => 23],
            [ 'panel_id' => 3 , 'colorpanel_id' => 25],
        ]);
    }
}
