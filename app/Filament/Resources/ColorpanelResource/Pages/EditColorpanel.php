<?php

namespace App\Filament\Resources\ColorpanelResource\Pages;

use App\Filament\Resources\ColorpanelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditColorpanel extends EditRecord
{
    protected static string $resource = ColorpanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
