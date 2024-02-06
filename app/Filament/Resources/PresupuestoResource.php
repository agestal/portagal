<?php

namespace App\Filament\Resources;
use App\Filament\Resources\PresupuestoResource\Pages;
use App\Filament\Resources\PresupuestoResource\RelationManagers;
use App\Models\Presupuesto;
//use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Color;
use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha'),
                Forms\Components\Select::make('puerta_id')
                    ->relationship('puertas', 'nombre'),
                Forms\Components\Select::make('diseno_id')
                    ->relationship('disenos', 'nombre'),
                Forms\Components\Select::make('pano_id')
                    ->relationship('panos', 'nombre'),
                Forms\Components\Select::make('apertura_id')
                    ->relationship('aperturas', 'nombre'),
                Forms\Components\Select::make('material_id')
                    ->relationship('materials', 'materials.nombre')
                    ->label('Material')
                    ->options(Material::all()->pluck('nombre','id')->toArray())
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    })
                    ->reactive(),
                Forms\Components\Select::make('color_id')
                    ->relationship('colors', 'colors.nombre')
                    ->options(function (callable $get, callable $set) {
                        if ( !is_null($get('material_id')) ) 
                        {
                            return Color::join('color_material','color_material.color_id','colors.id')->where('material_id',$get('material_id'))->get()->pluck('nombre','id')->toArray();
                        }
                        else 
                        {
                            return Color::join('color_material','color_material.color_id','colors.id')->get()->pluck('nombre','id')->toArray();
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('puertas.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('materials.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('colors.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf') 
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-document')
                    ->action(function (Presupuesto $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf', ['record' => $record])
                            )->stream();
                        }, $record->number.'.pdf');
                    }), 
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
            //RelationManagers\MaterialRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresupuestos::route('/'),
            'create' => Pages\CreatePresupuesto::route('/create'),
            'edit' => Pages\EditPresupuesto::route('/{record}/edit'),
        ];
    }
}
