<?php

namespace App\Forms\Components;
use Filament\Forms\Set;
use Filament\Forms\Components\Field;

class DrawingField extends Field
{
    protected string $view = 'forms.components.drawing';

    protected function setUp(): void
    {
        parent::setUp();

        // Asegurar que el campo se guarde y recupere correctamente
        $this->saveRelationshipsUsing(function ($state, $record, callable $set) {
            if (!empty($state)) {
                $set($this->getStatePath(), $state);
            }
        });

        $this->dehydrateStateUsing(fn ($state) => $state); // Mantiene el estado entre cargas
    }
    public static function make(string $name): static
    {
        return parent::make($name)
            ->afterStateUpdated(function (Set $set, $state, $name) {
                dump($state); // Ver si el estado cambia al hacer un dibujo
                $set($name, $state);
            });
    }
}
