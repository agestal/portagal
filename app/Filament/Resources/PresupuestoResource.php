<?php

namespace App\Filament\Resources;
use App\Filament\Resources\PresupuestoResource\Pages;
use App\Models\Presupuesto;
use App\Models\Puertamaterial;
//use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Material;
use App\Models\Panel;
use App\Models\Colorpanel;
use Barryvdh\DomPDF\Facade\Pdf;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Forms\Components\FileUpload;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use App\Models\Motor;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Wizard::make([
                Wizard\Step::make('Datos de cliente')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')->label(__('Fecha'))->default(now())->required(),
                        Forms\Components\TextInput::make('nombre_cliente')->label(__('Cliente'))->required(),
                        Forms\Components\TextInput::make('referencia')->label(__('Referencia'))->required(),
                        Forms\Components\TextInput::make('email')->regex('/^.+@.+$/i')->label(__('Email'))->required(),
                    ]),
                Wizard\Step::make('Opciones de la puerta')
                    ->schema([
                        Forms\Components\Select::make('puerta_id')->required()
                            ->relationship('puertas', 'nombre')
                            ->reactive()
                            ->label('Tipo de puerta'),
                        Section::make('Material de puerta')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4)) ? false : true; })
                            ->description('Datos sobre el material de la puerta')
                            ->schema([
                                Forms\Components\Select::make('puertamaterial_id')
                                    ->relationship('puertamaterials', 'puertamaterials.nombre')
                                    ->required()
                                    ->label('Material de la puerta')
                                    ->hidden(false)
                                    ->options(Puertamaterial::all()->pluck('nombre','id')->toArray())
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    })
                                    ->reactive(),
                            ])->collapsible(),
                        Section::make('Panel')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Escoge el tipo de panel y su color')
                            ->schema([
                                Forms\Components\Select::make('panel_id')
                                    ->relationship('panels', 'panels.nombre')
                                    ->required()
                                    ->label('Tipo de panel')
                                    ->hidden(false)
                                    ->options(Panel::all()->pluck('nombre','id')->toArray())
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    })
                                    ->reactive(),
                                Forms\Components\ToggleButtons::make('tipo_color_panel')
                                    ->label(__('Color de panel Estandard'))
                                    ->options([
                                        true => 'Estandard',
                                        false => 'No estandard',
                                    ])->inline()
                                    ->default( fn(Callable $get)  => $get('panel_id') ? !Panel::where('id',$get('panel_id'))->first()->puede_std : true )
                                    ->reactive()
                                    ->required(),
                                Forms\Components\Select::make('colorpanel_id')
                                    ->relationship('colorpanels', 'colorpanels.nombre')
                                    ->label('Color del panel (Estandard)')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->required()
                                    ->hidden(fn(Callable $get) => !$get('tipo_color_panel') )
                                    ->options(Colorpanel::where('std',1)->pluck('nombre','id')->toArray()),
                                Forms\Components\TextInput::make('colorpanel_no_std')
                                    ->label('Color del panel (No estandard)')
                                    ->required()
                                    ->hidden(fn(Callable $get) => $get('tipo_color_panel') ),
                            ])->collapsible(),
                        Section::make('Orejetas')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; })
                            ->description('Datos sobre las orejetas')
                            ->schema([
                                Forms\Components\Toggle::make('orejetas')->label(__('Orejetas'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                Forms\Components\TextInput::make('orejetas_medidas')
                                    ->label('Medidas de las orejetas')
                                    ->hidden(function (callable $get) { return !$get('orejetas'); }),
                                SignaturePad::make('orejetas_dibujo')->label(__('Dibujo de las orejetas'))->extraAttributes(['class' => 'fondo-pantalla'])->hidden(function (callable $get) { return !$get('orejetas'); }),
                            ])->collapsible(),
                        Section::make('Tipo de suelo')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Rellena aquí las opciones sobre el tipo de suelo')
                            ->schema([
                                Forms\Components\ToggleButtons::make('tipo_suelo')->label('Tipo de suelo')->inline()
                                ->options([
                                    '1' => 'Suelo Horizontal',
                                    '2' => 'Suelo con caída',
                                ])->reactive(),
                                Forms\Components\TextInput::make('sueloh_ancho')
                                    ->label('Ancho de paso libre')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 1 ? false : true; } )
                                    ->numeric(),
                                Forms\Components\TextInput::make('sueloh_alto')
                                    ->label('Alto de paso libre')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 1 ? false : true; } )
                                    ->numeric(),
                                Forms\Components\TextInput::make('sueloh_dintel')
                                    ->label('Dintel')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 1 ? false : true; } )
                                    ->numeric(),

                                Forms\Components\TextInput::make('suelocc_altod')
                                    ->label('Alto de paso libre derecha (V. Interior)')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 2 ? false : true; } )
                                    ->numeric(),
                                Forms\Components\TextInput::make('suelocc_altoi')
                                    ->label('Alto de paso libre izquierda (V. Interior)')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 2 ? false : true; } )
                                    ->numeric(),
                                Forms\Components\TextInput::make('suelocc_ancho')
                                    ->label('Ancho de paso libre')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 2 ? false : true; } )
                                    ->numeric(),
                                Forms\Components\TextInput::make('suelocc_dintel')
                                    ->label('Dintel')
                                    ->hidden(function (callable $get) { return $get('tipo_suelo') == 2 ? false : true; } )
                                    ->numeric(),

                                Forms\Components\Toggle::make('techo_inclinacion')
                                    ->label(__('Techo con inclinación'))
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {  })
                                    ->reactive(),
                                Forms\Components\TextInput::make('grados_inclinacion')
                                    ->label('Grados inclinación')
                                    ->hidden(fn(Callable $get) => !$get('techo_inclinacion') )
                                    ->numeric(),
                            ])->collapsible(),
                        Section::make('Datos pilares')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4)) ? false : true; })
                            ->description('Datos de los pilares')
                            ->schema([
                                Forms\Components\TextInput::make('pilares_ancho')
                                    ->label('Ancho')
                                    ->numeric(),
                                Forms\Components\TextInput::make('pilares_alto')
                                    ->label('Alto')
                                    ->numeric(),
                            ])->collapsible(),
                        Section::make('Datos sobre la orientación')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4)) ? false : true; })
                            ->description('Orientación')
                            ->schema([
                                Forms\Components\ToggleButtons::make('orientaion')->label('orientaion')->inline()
                                ->options([
                                    '1' => 'Horizontal',
                                    '2' => 'Vertical',
                                    '2' => 'Mixta',
                                ])->reactive(),
                            ])->collapsible(),
                        Section::make('Dintel')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Opciones de dintel')
                            ->schema([
                                Forms\Components\Toggle::make('dintel_panel')->label(__('Dinel del panel'))->reactive(),
                                Forms\Components\TextInput::make('dintel_ancho')
                                    ->label('Ancho')
                                    ->hidden(fn(Callable $get) => !$get('dintel_panel') )
                                    ->numeric(),
                                Forms\Components\TextInput::make('dintel_alto')
                                    ->label('Alto')
                                    ->hidden(fn(Callable $get) => !$get('dintel_panel') )
                                    ->numeric(),
                            ])->collapsible(),
                        Section::make('Tubos laterales')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Opciones de los tubos laterales')
                            ->schema([
                                Forms\Components\Toggle::make('tubos_laterales')->label(__('Tubos laterales'))->reactive(),
                                Forms\Components\TextInput::make('tubos_cantidad')
                                    ->label('Cantidad')
                                    ->hidden(fn(Callable $get) => !$get('tubos_laterales') )
                                    ->numeric(),
                                Forms\Components\TextInput::make('tubos_alto')
                                    ->label('Alto')
                                    ->hidden(fn(Callable $get) => !$get('tubos_laterales') )
                                    ->numeric(),
                                Forms\Components\TextInput::make('tubos_color')
                                    ->label('Color')
                                    ->hidden(fn(Callable $get) => !$get('tubos_laterales') ),
                            ])->collapsible(),
                        Section::make('Ventanas')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Marca aquí si incluyes ventanas')
                            ->schema([
                                Forms\Components\Toggle::make('ventanas')->label(__('Ventanas'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                Forms\Components\TextInput::make('numero_ventanas')
                                    ->label('Numero de ventanas')
                                    ->hidden(fn(Callable $get) => !$get('ventanas') )
                                    ->numeric(),
                                Forms\Components\ToggleButtons::make('ventana_tipo')->label(__('Tipo de ventana'))->inline()
                                    ->options([
                                        '1' => 'Residencial 520 x 350',
                                        '2' => 'Industrial 609 x 146',
                                        '3' => 'Industrial 609 x 203',
                                        '4' => 'Industrial ovalada 670 x 345',
                                    ])->hidden(fn(Callable $get) => !$get('ventanas') ),
                                Forms\Components\ToggleButtons::make('ventana_tipo_cristal')->label(__('Tipo de cristal (ventana)'))->inline()
                                    ->options([
                                        '1' => 'Transparente',
                                        '2' => 'Translucida',
                                        '3' => 'Opaca',
                                    ])->hidden(fn(Callable $get) => !$get('ventanas') ),
                                Forms\Components\Textarea::make('posicion_ventanas')
                                    ->label('Posición ventanas')
                                    ->hidden(fn(Callable $get) => !$get('ventanas') ),
                            ])->collapsible()->collapsed(),
                        Section::make('Rejillas')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Marca aquí si incluyes rejillas')
                            ->schema([
                                Forms\Components\Toggle::make('rejillas')->label(__('Rejillas'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                Forms\Components\TextInput::make('numero_rejillas')
                                        ->label('Numero de rejillas')
                                        ->hidden(fn(Callable $get) => !$get('rejillas') )
                                        ->numeric(),
                                Forms\Components\ToggleButtons::make('rejillas_tipo')->label(__('Tipo de rejillas'))->inline()
                                        ->options([
                                            '1' => 'Estándar 337 x 131',
                                            '2' => 'Grande 500 x 330',
                                        ])->hidden( function (callable $get) {
                                            return !$get('rejillas');
                                        }),
                                Forms\Components\Textarea::make('posicion_rejillas')
                                        ->label('Posición rejillas')
                                        ->hidden(fn(Callable $get) => !$get('rejillas') ),
                            ])->collapsible()->collapsed(),
                        Section::make('Buzón')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4)) ? false : true; })
                            ->description('Marca aquí si incluyes buzón')
                            ->schema([
                                Forms\Components\Toggle::make('buzon')->label(__('Buzon'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                Forms\Components\ToggleButtons::make('buzon_tipo')->label(__('Tipo de buzón'))->inline()
                                        ->options([
                                            '1' => 'Inox',
                                            '2' => 'Lacado RAL',
                                        ])->hidden( function (callable $get) {
                                            return !$get('buzon');
                                        }),
                            ])->collapsible()->collapsed(),
                        Section::make('Bate contra U')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                            ->description('Marca aquí si bate contra U')
                            ->schema([
                                Forms\Components\Toggle::make('bate_contrau')->label(__('Bate contra U'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                            ])->collapsible()->collapsed(),
                        Section::make('Guía de suelo')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                            ->description('Opciones de la guía de suelo')
                            ->schema([
                                Forms\Components\Toggle::make('guia_suelo')->label(__('Guía de suelo'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                Forms\Components\ToggleButtons::make('tipo_guia_suelo')->label(__('Tipo de guía'))->inline()->reactive()
                                        ->options([
                                            '1' => 'De atornillar',
                                            '2' => 'Embutida',
                                        ])->hidden( function (callable $get) {
                                            return !$get('guia_suelo');
                                        }),
                                Forms\Components\ToggleButtons::make('material_guia_suelo')->label(__('Material de guía'))->inline()
                                        ->options([
                                            '1' => 'Inox',
                                            '2' => 'Acero galvanizado',
                                        ])->hidden( function (callable $get) {
                                            return $get('tipo_guia_suelo') == 1 ? false : true;
                                        }),
                            ])->collapsible()->collapsed(),
                        Section::make('Peatonal')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2,3,4)) ? false : true; })
                            ->description('Marca aquí si incluyes una puerta peatonal')
                            ->schema([
                                    Forms\Components\Toggle::make('peatonal_insertada')->label(__('Peatonal'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                   Grid::make()->columns(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('peatonal_cierrapuertas')->label(__('Cierrapuertas (peatonal)'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive()
                                        ->hidden( function (callable $get) {
                                            return !$get('peatonal_insertada');
                                        }),
                                        Forms\Components\Toggle::make('peatonal_seguridad')->label(__('Seguridad (peatonal)'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive()
                                        ->hidden( function (callable $get) {
                                            return !$get('peatonal_insertada');
                                        }),
                                        //Forms\Components\ImageEntry::make('author.avatar'),
                                        Forms\Components\ToggleButtons::make('peatonal_apertura')->label('Apertura')->inline()
                                            ->options([
                                                '1' => 'Interior Derecha',
                                                '2' => 'Interior Izquierda',
                                                '3' => 'Exterior Derecha',
                                                '4' => 'Exterior Izquierda',
                                            ])
                                            ->hidden( function (callable $get) {
                                                return !$get('peatonal_insertada');
                                            }),
                                        Forms\Components\ToggleButtons::make('peatonal_posicion')->label('Posicion (V. Interior)')->inline()
                                            ->options([
                                                '1' => 'Derecha',
                                                '2' => 'Centro',
                                                '3' => 'Izquierda',
                                            ])
                                            ->default(2)
                                            ->hidden( function (callable $get) {
                                                return !$get('peatonal_insertada');
                                            }),
                                        Forms\Components\ToggleButtons::make('peatonal_bisagras')->label('Bisagras')->inline()
                                            ->options([
                                                '1' => 'Normal',
                                                '2' => 'Oculta',
                                            ])
                                            ->hidden( function (callable $get) {
                                                return !$get('peatonal_insertada');
                                            }),
                                        Forms\Components\ToggleButtons::make('peatonal_umbral')->label('Umbral')->inline()
                                            ->options([
                                                '1' => 'Normal',
                                                '2' => 'Reducido',
                                            ])
                                            ->hidden( function (callable $get) {
                                                return !$get('peatonal_insertada');
                                            }),
                                        Forms\Components\ToggleButtons::make('peatonal_cerradura')->label('Cerradura')->inline()
                                            ->options([
                                                '1' => 'Normal',
                                                '2' => '3 puntos',
                                            ])
                                            ->hidden( function (callable $get) {
                                                return !$get('peatonal_insertada');
                                            }),
                                    ])
                            ])->collapsible()->collapsed(),
                        Section::make('Funcionamiento')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2,3,4)) ? false : true; })
                            ->description('Marca aquí si la puerta es manual o automática')
                            ->schema([
                                Forms\Components\ToggleButtons::make('funcionamiento')->inline()
                                    ->options([
                                        '1' => 'Manual',
                                        '2' => 'Automática',
                                    ])
                                    ->reactive(),
                                Forms\Components\Select::make('tipomotors_id')
                                    ->label('Tipo de motor')
                                    ->relationship('tipomotors','tipo_motor.nombre')
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 2 ? false : true;
                                    })
                                    ->reactive(),
                                Forms\Components\Select::make('motors_id')
                                    ->label('Modelo de motor')
                                    ->relationship('motors','motors.nombre')
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 2 ? false : true;
                                    })
                                    ->options(function (callable $get, callable $set) {
                                        return Motor::where('tipomotors_id',$get('tipomotors_id'))->orderBy('nombre','desc')->pluck('nombre','id')->toArray();
                                    })
                                    ->reactive(),
                                Forms\Components\Repeater::make('opcionpresupuesto')
                                    ->relationship('opcionpresupuesto')
                                    ->label('Opciones')
                                    ->schema([
                                        Forms\Components\Select::make('opcion_id')
                                            ->relationship('opcion','nombre')
                                            ->label('Opcion'),
                                        Forms\Components\TextInput::make('valor')
                                    ])
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 2 ? false : true;
                                    })->columns(2),

                                Forms\Components\TextInput::make('manual_tirador')
                                    ->label(__('Tirador'))
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 1 ? false : true;
                                    }),
                                    Forms\Components\TextInput::make('manual_cerradura')
                                        ->label(__('Cerradura tipo FAC'))
                                        ->hidden( function (callable $get) {
                                            return $get('funcionamiento') == 1 ? false : true;
                                        }),
                            ])->collapsible(),
                        Section::make('Otras opciones')->columns(1)->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->schema([
                                Forms\Components\Toggle::make('muelles_antirotura')->label(__('Muelles antirotura'))->reactive()->default(true),
                                Forms\Components\Toggle::make('soporte_guia_lateral')->label(__('Soporte guía lateral'))->reactive()->default(true),
                                Forms\Components\Toggle::make('paracaidas')->label(__('Paracaídas'))->reactive(),
                                Forms\Components\ToggleButtons::make('color_herraje_std')
                                    ->label(__('Color herrajes'))->inline()->reactive()
                                    ->options([
                                        '1' => 'Blanco (Estandard)',
                                        '2' => 'Otro color',
                                    ])->default(1),
                                Forms\Components\TextInput::make('color_herraje_no_std')
                                    ->label(__('Color herrajes no estándard'))
                                    ->hidden( function (callable $get) {
                                        return $get('color_herraje_std') == 2 ? false : true;
                                    }),
                                Forms\Components\ToggleButtons::make('color_guias_std')
                                    ->label(__('Color guias'))->inline()->reactive()
                                    ->options([
                                        '1' => 'Sin lacar (Estandard)',
                                        '2' => 'Otro color',
                                    ])->default(1),
                                Forms\Components\TextInput::make('color_guias_no_std')
                                    ->label(__('Color guias no estándard'))
                                    ->hidden( function (callable $get) {
                                        return $get('color_guias_std') == 2 ? false : true;
                                    }),

                            ])->collapsible()->collapsed(),








                        /*Forms\Components\Repeater::make('funcionamientopresupuesto')
                            ->relationship()
                            ->label('Funcionamientos')
                            ->schema([
                                Forms\Components\Select::make('funcionamiento_id')
                                    ->relationship('funcionamiento','nombre')
                                    ->label('Funcionamiento'),
                                Forms\Components\TextInput::make('valor')
                            ])->columns(2),*/
                    ]),
                Wizard\Step::make('Datos para obra y montaje')
                ->schema([
                    Section::make('Opciones')
                        ->description('Marca las opcioones correspondientes')
                        ->schema([
                            Grid::make()->schema([
                                Forms\Components\Toggle::make('electricidad')->label(__('Electricidad'))->reactive(),
                                Forms\Components\Textarea::make('electricidad_comentarios')
                                    ->label('Electricidad comentarios')
                                    ->hidden(fn(Callable $get) => !$get('electricidad') ),

                                Forms\Components\Toggle::make('obras')->label(__('Albañilería'))->reactive(),
                                Forms\Components\Textarea::make('obras_comentarios')
                                    ->label('Albañilería comentarios')
                                    ->hidden(fn(Callable $get) => !$get('obras') ),

                            ])->columns(1),
                        ]),
                    Section::make('Otras opciones')
                        ->description('Marca las opcioones correspondientes')
                        ->collapsed()
                        ->schema([
                            Grid::make()->schema([
                                Forms\Components\Select::make('materiales_pilares')
                                    ->label('Materiales de los pialres')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->options(Material::pluck('nombre','id')->toArray()),
                                Forms\Components\Select::make('materiales_techo')
                                    ->label('Materiales del techo')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->options(Material::pluck('nombre','id')->toArray()),
                                Forms\Components\TextInput::make('distancia_vertical')->label(__('Distancia suelo techo: (CMs)'))->numeric(),
                                Forms\Components\TextInput::make('distancia_horizontal')->label(__('Distancia entre paredes: (CMs)'))->numeric(),

                                Forms\Components\ToggleButtons::make('elevador')->label('Elevador: ')->inline()
                                    ->options([
                                        '1' => 'No se necesita',
                                        '2' => 'Lo aporta Portagal',
                                        '3' => 'Lo aporta el cliente',
                                    ]),
                                Forms\Components\Select::make('elevador_portagal')->label('Elevador tipo:')
                                    ->options([
                                        '1' => 'Tijera Electrica 8m',
                                        '2' => 'Tijera electrica 10m',
                                        '3' => 'Tijera electrica 12m',
                                        '4' => 'Tijera Diesel Pequeña',
                                        '5' => 'Tijera Diesel Grande',
                                        '6' => 'Pato 12m',
                                        '7' => 'Camion Cesta',
                                        '8' => 'Andamio',
                                    ])->hidden(function (callable $get) {
                                        return $get('elevador') == 2 ? false : true;
                                    }),
                            ])->columns(1),
                        ]),
                    Section::make('Dibujos aclaratorios')
                        ->schema([
                            SignaturePad::make('montaje_guias')->label(__('Montaje Guías')),
                            SignaturePad::make('remates')->label(__('Remates')),
                            SignaturePad::make('portico')->label(__('Pórtico')),
                        ]),
                    ]),
                Wizard\Step::make('Imagenes')
                    ->schema([
                        FileUpload::make('fotos')->multiple(),
                ]),
                Wizard\Step::make('Firma')
                    ->schema([
                        Geocomplete::make('full_address'),
                        Map::make('location')
                            ->defaultLocation([43.333120461082714 , -8.36360451626186])
                            ->geolocate() // adds a button to request device location and set map marker accordingly
                            ->geolocateLabel('Get Location') // overrides the default label for geolocate button
                            ->geolocateOnLoad(true, false) // geolocate on load, second arg 'always' (default false, only for new form)
                            ->autocomplete('full_address')
                            ->geolocateOnLoad(true, false)
                            ->mapControls([
                                'mapTypeControl'    => true,
                                'scaleControl'      => true,
                                'streetViewControl' => true,
                                'rotateControl'     => true,
                                'fullscreenControl' => true,
                                'searchBoxControl'  => false,
                                'zoomControl'       => true,
                            ])
                            ->draggable() // allow dragging to move marker
                            ->clickable(true)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('lat', $state['lat']);
                                $set('lon', $state['lng']);
                            }),

                        Forms\Components\TextInput::make('lat')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => floatVal($state),
                                    'lng' => floatVal($get('lon')),
                                ]);
                            })
                            ->lazy(), // important to use lazy, to avoid updates as you type
                        Forms\Components\TextInput::make('lon')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => floatval($get('lat')),
                                    'lng' => floatVal($state),
                                ]);
                            })
                            ->lazy(), // important to use lazy, to avoid updates as you type

                        SignaturePad::make('firma')->extraAttributes(['class' => 'fondo-pantalla'],true),



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
                ])->skippable(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('puertas.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre_cliente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_address')->label('Dirección')
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
