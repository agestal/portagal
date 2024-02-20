<?php

namespace App\Filament\Resources\PanelResource\Pages;

use App\Filament\Resources\PanelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreatePanel extends CreateRecord
{
    protected static string $resource = PanelResource::class;
    protected static ?string $title =  "Modelo de panel"; 

}
