<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;


class DibujoField extends Field
{
    protected string $view = 'forms.components.dibujo-field';

    public function getState(): mixed
    {
        return parent::getState();
    }

    public function setState(mixed $state): static
    {
        return parent::setState($state);
    }
}
