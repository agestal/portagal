<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuiamotorsResource\Pages;
use App\Filament\Resources\GuiamotorsResource\RelationManagers;
use App\Models\Guiamotors;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuiamotorsResource extends Resource
{
    protected static ?string $model = Guiamotors::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $navigationLabel = 'Guias para motores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuiamotors::route('/'),
            'create' => Pages\CreateGuiamotors::route('/create'),
            'edit' => Pages\EditGuiamotors::route('/{record}/edit'),
        ];
    }
}
