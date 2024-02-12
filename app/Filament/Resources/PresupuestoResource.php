<?php

namespace App\Filament\Resources;
use App\Filament\Resources\PresupuestoResource\Pages;
use App\Filament\Resources\PresupuestoResource\RelationManagers;
use App\Models\Presupuesto;
use Filament\Forms\Components\Fieldset;
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
use App\Models\Panel;
use App\Models\Opcion;
use App\Models\Colorpanel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\CheckboxList;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Forms\Components\FileUpload;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Grid;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Wizard::make([
                Wizard\Step::make('Datos de cliente')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')
                            ->default(now()),
                        Forms\Components\TextInput::make('nombre_cliente'),
                        Forms\Components\TextInput::make('pedido'),
                        Forms\Components\TextInput::make('email')->regex('/^.+@.+$/i'),
                    ]),
                Wizard\Step::make('Opciones de la puerta')
                    ->schema([
                        Forms\Components\Select::make('puerta_id')
                            ->relationship('puertas', 'nombre')
                            ->label('Tipo de puerta'),
                        Forms\Components\Select::make('panel_id')
                            ->relationship('panels', 'panels.nombre')
                            ->label('Tipo de panel')
                            ->hidden(false)
                            ->options(Panel::all()->pluck('nombre','id')->toArray())
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            })
                            ->reactive(),
                        Forms\Components\Select::make('colorpanel_id')
                            ->relationship('colorpanels', 'colorpanels.nombre')
                            ->label('Color del panel')
                            ->searchable()
                            ->preload()
                            ->options(function (callable $get, callable $set) {
                                if ( !is_null($get('panel_id')) ) 
                                {
                                    $std = Panel::where('id',$get('panel_id'))->select('puede_std')->first();
                                    if ( $std->puede_std == true )
                                    {
                                        return Colorpanel::all()->pluck('nombre','id')->toArray();
                                    }
                                    else
                                    {  
                                        return Colorpanel::where('std',0)
                                                ->get()
                                                ->pluck('nombre','id')
                                                ->toArray();
                                    }
                                }
                                else 
                                {
                                    return Colorpanel::get()->pluck('nombre','id')->toArray();
                                }
                            }),
                        Forms\Components\Repeater::make('opcionpresupuesto')
                            ->relationship()
                            ->label('Opciones')
                            ->schema([
                                Forms\Components\Select::make('opcion_id')
                                    ->relationship('opcion','nombre')
                                    ->label('Opcion'),
                                Forms\Components\TextInput::make('valor')
                            ])->columns(2),
                    ]),
                Wizard\Step::make('Datos para montaje')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\Checkbox::make('electricidad')->label('Incluimos electricidad: '),
                            Forms\Components\TextInput::make('distancia_horizontal')->label('Distancia entre paredes: (CMs)')->numeric(),
                            Forms\Components\Checkbox::make('obras')->label('Incluimos albañilería: '),
                            Forms\Components\TextInput::make('distancia_vertical')->label('Distancia suelo techo: (CMs)')->numeric(),
                            Forms\Components\Checkbox::make('elevador')->label('Incluimos elevador: '),
                        ])->columns(2),

                    ]),
                Wizard\Step::make('Imagenes')
                    ->schema([
                        FileUpload::make('archivo1'),
                ]),
                Wizard\Step::make('Firma')
                    ->schema([
                        SignaturePad::make('firma'),
                ]),
                /*Forms\Components\Select::make('material_id')
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
                    }),*/
                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('puertas.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('panels.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('colorpanels.nombre')
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
                    ->url(fn (Presupuesto $record) => route('pdf', $record))
                    ->openUrlInNewTab(), 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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
