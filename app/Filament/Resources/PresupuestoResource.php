<?php
namespace App\Filament\Resources;
use App\Filament\Resources\PresupuestoResource\Pages;
use App\Models\Presupuesto;
use App\Models\Puertamaterial;
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
use App\Models\TipoMotor;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms\Components\Fieldset;
class PresupuestoResource extends Resource
{
    protected static ?string $modeLabel = "Medicion";
    protected static ?string $label = "Medicion";
    protected static ?string $pluralModelLabel = "Mediciones";
    protected static ?string $navigationLabel = "Mediciones";
    protected static ?string $model = Presupuesto::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getSlug(): string
    {
        return 'mediciones';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Wizard::make([
                Wizard\Step::make('Datos de cliente')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')->label(_('Fecha'))->default(now())->required(),
                        Forms\Components\TextInput::make('nombre_cliente')->label(_('Cliente'))->required(),
                        Forms\Components\TextInput::make('referencia')->label(_('Referencia'))->required(),
                        Forms\Components\TextInput::make('email')->regex('/^.+@.+$/i')->label(_('Email'))->required(),
                    ]),
                Wizard\Step::make('Opciones de la puerta')
                    ->schema([
                        Forms\Components\Select::make('puerta_id')->required()
                            ->relationship('puertas', 'nombre')
                            ->reactive()
                            ->label('Tipo de puerta'),
                            Section::make('Modelo de Panel')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
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
                                    ->label(_('Color de panel'))
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
                                    ->options(fn(Callable $get) =>  Colorpanel::where('panels_id',$get('panel_id'))->pluck('nombre','id')->toArray()),
                                Forms\Components\TextInput::make('colorpanel_no_std')
                                    ->label('Color del panel (No estandard)')
                                    ->required()
                                    ->hidden(fn(Callable $get) => $get('tipo_color_panel') ),
                            ])->collapsible(),
                        Section::make('Diseño y material de puerta')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4,5)) ? false : true; })
                            ->description('Escoge el diseño y material de la puerta')
                            ->schema([

                                Forms\Components\ToggleButtons::make('tipo_vivienda')->label('Tipo de vivienda')->inline()
                                    ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; })
                                    ->options([
                                        '1' => 'Residencial',
                                        '2' => 'Comunitaria',
                                    ])->reactive(),

                                Forms\Components\Select::make('puertamaterial_id')
                                    ->relationship('puertamaterials', 'puertamaterials.nombre')
                                    ->required()
                                    ->label('Material de la puerta')
                                    ->hidden(false)
                                    ->options(Puertamaterial::all()->pluck('nombre','id')->toArray())
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    })
                                    ->reactive(),
                                Forms\Components\Select::make('opciones_pano')
                                    ->label('Diseño')
                                    ->hidden(function (Callable $get) { return in_array($get('puertamaterial_id'),array(1)) ? false : true; })
                                    ->options([
                                        '1' => 'Lama 100 vertical',
                                        '2' => 'Lama 100 horizontal',
                                        '3' => 'Lama 200 vertical',
                                        '4' => 'Lama 200 horizontal',
                                        '5' => 'Lama 100 horizontal imitación madera clara',
                                        '6' => 'Lama 100 vertical imitación madera clara',
                                        '7' => 'Lama 100 horizontal imitación madera oscura',
                                        '8' => 'Lama 100 vertical imitación madera oscura',
                                        '9' => 'Lama 200 horizontal imitación madera clara',
                                        '10' => 'Lama 200 vertical imitación madera clara',
                                        '11' => 'Lama 200 horizontal imitación madera oscura',
                                        '12' => 'Lama 200 vertical imitación madera oscura',
                                        '13' => 'Diseño especial',
                                    ])->reactive(),
                                Forms\Components\Select::make('opciones_pano')
                                    ->label('Diseño')
                                    ->hidden(function (Callable $get) { return in_array($get('puertamaterial_id'),array(2)) ? false : true; })
                                    ->options([
                                        '14' => 'Lama PC4 horizontal',
                                        '15' => 'Lama PC4 vertical',
                                        '16' => 'Lama PC4 rayada horizontal',
                                        '17' => 'Lama PC4 rayada vertical',
                                        '18' => 'Malla electrosoldada',
                                        '13' => 'Diseño especial',
                                    ])->reactive(),
                                Forms\Components\Select::make('opciones_pano')
                                    ->label('Diseño')
                                    ->hidden(function (Callable $get) { return in_array($get('puertamaterial_id'),array(3)) ? false : true; })
                                    ->options([
                                        '20' => 'Acanalado horizontal imitación madera clara',
                                        '21' => 'Acanalado vertical imitación madera clara',
                                        '22' => 'Acanalado horizontal imitación madera oscura',
                                        '23' => 'Acanalado vertical imitación madera oscura',
                                        '24' => 'Unicanal horizontal imitación madera clara',
                                        '25' => 'Unicanal vertical imitación madera clara',
                                        '26' => 'Unicanal horizontal imitación madera oscura',
                                        '27' => 'Unicanal vertical imitación madera oscura',
                                        '28' => 'Acanalado pintado',
                                        '29' => 'Uniacanalado pintado',
                                        '30' => 'Superliso pintado',
                                        '13' => 'Diseño especial',
                                    ])->reactive(),
                                Forms\Components\Textarea::make('diseno_especial')
                                    ->hidden(function (Callable $get) { return in_array($get('opciones_pano'),array(13)) ? false : true; })
                                    ->label('Describe el diseño')
                                    ->reactive(),
                                Forms\Components\TextInput::make('color_pano')
                                    ->label('Color de la puerta (color del marco para las imitación madera)')
                                    ->reactive(),
                            ])->collapsible(),
                        Section::make('Medicion')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2,3,4,5)) ? false : true; })
                            ->description('Relleno aquí las medidas de la puerta')
                            ->schema([
                                Fieldset::make('Medidas de Hueco (en mm.)')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,5)) ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('ancho_plibre')
                                        ->label('ANCHO DE PASO LIBRE')
                                        ->numeric()
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2)) ? false : true; }),

                                    Forms\Components\TextInput::make('ancho_hueco')
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                        ->label('ANCHO DE HUECO')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('puerta_derecha_int')
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                                        ->label('ALTURA DE PUERTA DERECHA (vista interior)')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('puerta_izquierda_int')
                                        ->label('ALTURA DE PUERTA IZQUIERDA (vista interior)')
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                                        ->numeric(),

                                ]),

                                Fieldset::make('Medidas de Hueco (en mm.)')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4)) ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('ancho_plibre')
                                        ->label('ANCHO DE PASO LIBRE')
                                        ->numeric()
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2)) ? false : true; }),
                                    Forms\Components\TextInput::make('ancho_pilares')
                                        ->label('ANCHO ENTRE PILARES O PAREDES')
                                        ->numeric()
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; }),
                                    Forms\Components\TextInput::make('puerta_izquierda_ext')
                                        ->label('ALTURA DE PUERTA IZQUIERDA (vista exterior)')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('puerta_derecha_ext')
                                        ->label('ALTURA DE PUERTA DERECHA (vista exterior)')
                                        ->numeric(),
                                ]),

                                Fieldset::make('Tipo de Guía y Medida de Dintel')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                                ->schema([
                                    Forms\Components\Select::make('tipo_guia')
                                        ->label('Tipo de guía')
                                        ->options([
                                            '1' => 'Guía con muelles atrás',
                                            '2' => 'Guía Doble',
                                            '3' => 'Guía Inclinada',
                                            '4' => 'Guía Simple',
                                            '5' => 'Guillotina',
                                        ])->reactive(),
                                    Forms\Components\TextInput::make('medida_dintel')
                                        ->label('Medida de Dintel (en mm.)')
                                        ->hidden(function (Callable $get) { return in_array($get('tipo_guia'),array(3,4,5)) ? false : true; })
                                        ->numeric()
                                        ->reactive(),
                                    Forms\Components\TextInput::make('medida_dintel')
                                        ->label('Medida de Dintel (en mm.)')
                                        ->minValue(120)
                                        ->maxValue(195)
                                        ->live()
                                        ->hidden(function (Callable $get) { return in_array($get('tipo_guia'),array(1)) ? false : true; })
                                        ->reactive()
                                        ->numeric(),
                                    Forms\Components\TextInput::make('medida_dintel')
                                        ->label('Medida de Dintel (en mm.)')
                                        ->minValue(200)
                                        ->maxValue(295)
                                        ->live()
                                        ->reactive()
                                        ->hidden(function (Callable $get) { return in_array($get('tipo_guia'),array(2)) ? false : true; })
                                        ->numeric(),
                                    Forms\Components\TextInput::make('grados_inclinacion')
                                        ->label('Grados de inclinación')
                                        ->hidden(function (Callable $get) { return in_array($get('tipo_guia'),array(3)) ? false : true; })
                                        ->numeric()
                                        ->reactive(),
                                ]),
                                Fieldset::make('Altura de pilares')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4,5)) ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('pilar_izquierdo')
                                        ->label('ALTURA DE PILAR IZQUIERDO (vista exterior)')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('pilar_derecho')
                                        ->label('ALTURA DE PILAR DERECHO (vista exterior)')
                                        ->numeric(),
                                ]),
                                Fieldset::make('Altura de pilares')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('pilar_izquierdo')
                                        ->label('ALTURA DE PILAR IZQUIERDO (vista interior)')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('pilar_derecho')
                                        ->label('ALTURA DE PILAR DERECHO (vista interior)')
                                        ->numeric(),
                                ]),
                                Forms\Components\ToggleButtons::make('direccion_apertura')->label('Dirección de apertura (vista exterior)')->inline()
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->options([
                                    '1' => 'ABRE HACIA LA IZQUIERDA',
                                    '2' => 'ABRE HACIA LA DERECHA',
                                ])->reactive(),
                                Forms\Components\ToggleButtons::make('direccion_apertura')->label('Dirección de apertura (vista exterior)')->inline()
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(4)) ? false : true; })
                                ->options([
                                    '1' => 'ABRE HACIA INTERIOR',
                                    '2' => 'ABRE HACIA EXTERIOR',
                                ])->reactive(),
                                Forms\Components\ToggleButtons::make('direccion_apertura')->label('Dirección de apertura (vista exterior)')->inline()
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,5)) ? false : true; })
                                ->options([
                                    '1' => 'ABRE HACIA LA IZQUIERDA INTERIOR',
                                    '2' => 'ABRE HACIA LA DERECHA INTERIOR',
                                    '3' => 'ABRE HACIA LA IZQUIERDA EXTERIOR',
                                    '4' => 'ABRE HACIA LA DERECHA EXTERIOR',
                                ])->reactive(),
                                Fieldset::make('Solapes de la puerta')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('solape_motor')
                                        ->label('Solape lado motor')
                                        ->default(80)
                                        ->numeric(),
                                    Forms\Components\TextInput::make('solape_cierra')
                                        ->label('Solape lado que cierra')
                                        ->default(80)
                                        ->numeric(),
                                ]),
                                Fieldset::make('Holgura inferior')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4,5)) ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('holgura_inferior')
                                        ->label('Holgura')
                                        ->numeric(),
                                ]),
                                Forms\Components\ToggleButtons::make('rabos')->label('Puerta corre por el exterior (sin rabos)')->inline()->default(2)
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->options([
                                    '1' => 'Si',
                                    '2' => 'No',
                                ])->reactive(),
                                Fieldset::make('Medida rabos de la puerta')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) && $get('rabos') == 2 ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('rabo_superior')
                                        ->label('Rabo superior')
                                        ->default(200)
                                        ->numeric(),
                                    Forms\Components\TextInput::make('rabo_inferior')
                                        ->label('Rabo inferior')
                                        ->default(200)
                                        ->numeric(),
                                ]),
                                Forms\Components\Toggle::make('puerta_caida')->label('Puerta con caída')->inline()->default(false)
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4,5)) ? false : true; })->reactive(),
                                Forms\Components\Select::make('opciones_caida')
                                ->hidden(function (Callable $get) { return $get('puerta_caida') == 1 && in_array($get('puerta_id'),array(2,3,4,5)) ? false : true; })
                                ->label('Caída de la puerta')
                                ->options([
                                    '1' => 'Sólo caída inferior',
                                    '2' => 'Sólo caída superior',
                                    '3' => ' Con caída superior e inferior',
                                ])->reactive(),
                                SignaturePad::make('caida_dibujo')->label(_('Dibujo de la caída'))->hidden(function (Callable $get) { return $get('puerta_caida') == 1 && in_array($get('puerta_id'),array(2,3,4,5)) ? false : true; }),

                                Forms\Components\Select::make('tipo_cierre')
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->label('Tipo de cierre puerta corredera')
                                ->options([
                                    '1' => 'Tandem corto con rodillo',
                                    '2' => 'Bate contra U, directamente a pilar',
                                    '3' => 'Bate contra U, con tubo detrás de la U',
                                    '4' => 'Bate contra U, amarrada lateralmente a pilar, con orejetas',
                                    '5' => 'Bate contra U, amarrada lateralmente a pilar, con tubo',
                                ])->reactive(),
                                Forms\Components\Select::make('tipo_cierre_peatonal')
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                ->label('Tipo de cierre puerta peatonal')
                                ->options([
                                    '1' => 'Cerradura con coqueta eléctrica',
                                    '2' => 'Con electrocerradura CISA',
                                    '3' => 'Sin coqueta eléctrica',
                                ])->reactive(),
                                Forms\Components\Select::make('guia_suelo')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->label('Guía de suelo')
                                ->options([
                                    '1' => 'Se conserva guía',
                                    '2' => 'Guía de atonillar',
                                    '3' => 'Guía embutida',
                                ])->reactive(),

                                Forms\Components\Select::make('material_guia_suelo')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->label('Material guía de suelo')
                                ->options([
                                    '1' => 'Inox',
                                    '2' => 'Acero Galvanizado',
                                ])->reactive(),
                                Forms\Components\ToggleButtons::make('rueda')->label('Tipo de rueda')->inline()
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) ? false : true; })
                                ->options([
                                    '1' => 'Redonda 80x20 con soporte',
                                    '2' => 'Otro tipo o medida de ruedas',
                                ])->reactive(),
                                Forms\Components\Textarea::make('descripcion_rueda')
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2)) && $get('rueda') == 2 ? false : true; })
                                ->label('Descripción de la rueda')
                                ->reactive(),
                                Forms\Components\Toggle::make('pano_fijo_hoja_aux')->label('Paño fijo o hoja auxiliar')->inline()->default(false)
                                ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })->reactive(),
                                Fieldset::make('Medidas del fijo o hoja auxiliar')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) &&  $get('pano_fijo_hoja_aux') == 1 ? false : true; })
                                ->schema([
                                    Forms\Components\TextInput::make('ancho_fijo_aux')
                                        ->label('Ancho de fijo o hoja auxiliar')
                                        ->numeric(),
                                    Forms\Components\TextInput::make('alto_fijo_aux')
                                        ->label('Alto de fijo o hoja auxiliar')
                                        ->numeric(),
                                    Forms\Components\ToggleButtons::make('configuracion_hoja_aux')->label('Configuración (vista exterior)')->inline()
                                        ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                        ->options([
                                            '1' => 'Fijo o hoja auxiliar a la derecha',
                                            '2' => 'Fijo o hoja auxiliar a la izquierda',
                                            '3' => '2 fijos, uno a cada lado de la puerta peatonal',
                                        ])->reactive(),
                                ]),
                        ])->collapsible()->collapsed(),

                        Section::make('Peatonal insertada')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2,3,4)) ? false : true; })
                        ->description('Marca aquí si incluyes una puerta peatonal')
                        ->schema([
                               Grid::make()->columns(1)
                                ->schema([
                                    Forms\Components\Toggle::make('peatonal_cierrapuertas')
                                        ->label(_('Cierrapuertas (peatonal)'))
                                        ->reactive(),
                                    Forms\Components\ToggleButtons::make('peatonal_posicion')->label('Posicion (V. exterior)')->inline()
                                        ->options([
                                            '1' => 'Izquierda',
                                            '2' => 'Centro',
                                            '3' => 'Derecha',
                                    ])->default(2),
                                        Grid::make()->columns(1)
                                        ->schema([
                                            Forms\Components\ToggleButtons::make('peatonal_bisagras')->label('Bisagras')->inline()
                                                ->options([
                                                    '1' => 'Normal',
                                                    '2' => 'Oculta',
                                                ]),
                                            Forms\Components\ToggleButtons::make('peatonal_umbral')->label('Umbral')->inline()
                                                ->options([
                                                    '1' => 'Normal',
                                                    '2' => 'Reducido',
                                                ]),
                                            Forms\Components\ToggleButtons::make('peatonal_cerradura')->label('Cerradura')->inline()->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; })
                                                ->options([
                                                    '1' => 'Normal',
                                                    '2' => '3 puntos',
                                                ]),
                                        ]),
                                        Grid::make()->columns(1)
                                        ->schema([
                                            Forms\Components\ToggleButtons::make('peatonal_cerradura')->label('Cerradura')->inline()
                                                ->options([
                                                    '1' => 'Normal',
                                                    '3' => 'Con coqueta eléctrica',
                                                ]),
                                            ])->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; }),
                                        /* Forms\Components\ToggleButtons::make('peatonal_cerradura')->label('Cerradura')->inline()
                                            ->options([
                                                '1' => 'Normal',
                                            ]),*/
                                    ])->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; }),
                                    Grid::make()->columns(1)
                                    ->schema([
                                        Forms\Components\Toggle::make('peatonal_cierrapuertas')
                                            ->label(_('Cierrapuertas (peatonal)'))
                                            ->reactive()
                                            ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; }),
                                        Forms\Components\Toggle::make('peatonal_seguridad')->label(_('Seguridad (peatonal)'))
                                            ->afterStateUpdated(function ($state, callable $get, callable $set) { })
                                            ->reactive(),
                                        Forms\Components\ToggleButtons::make('peatonal_apertura')->label('Apertura')->inline()
                                            ->options([
                                                '1' => 'Interior Derecha',
                                                '2' => 'Interior Izquierda',
                                                '3' => 'Exterior Derecha',
                                                '4' => 'Exterior Izquierda',
                                            ]),
                                        Forms\Components\Select::make('manillas')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                            ->label('Manillas')
                                            ->options([
                                                '1' => 'Sin manillas',
                                                '2' => 'Sólo manilla exterior',
                                                '3' => 'Sólo manilla interior',
                                                '4' => 'Con manillas interior y exterior',
                                            ])->reactive()
                                            ->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4)) ? false : true; }),
                                    ]),
                                    Grid::make()->columns(1)
                                    ->schema([
                                        Signaturepad::make('dibujo_peatonal')->label('Dibujo peatonal'),
                                    ]),
                                    Grid::make()->columns(1)
                                    ->schema([
                                        Forms\Components\Textarea::make('observaciones_peatonal_ins')->label('Observaciones'),
                                    ])
                            ])->collapsible()->collapsed(),


                        Section::make('Accesorios y Opciones')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1,2,3,4,5)) ? false : true; })
                        ->description('Escoge accesorios y opciones')
                        ->schema([
                            Forms\Components\Select::make('manillas_peatonal')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                ->label('Manillas')
                                ->options([
                                    '1' => 'Sólo manilla interior',
                                    '2' => 'Sólo manilla exterior',
                                    '3' => 'Manilla interior y exterior',
                                    '4' => 'Sin manillas',
                                ])->reactive(),
                            Section::make('Dintel')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Dintel del panel')
                            ->schema([
                                Forms\Components\TextInput::make('dintel_ancho')
                                    ->label('Ancho')
                                    ->numeric(),
                                Forms\Components\TextInput::make('dintel_alto')
                                    ->label('Alto')
                                    ->numeric(),
                                Forms\Components\ToggleButtons::make('modelo_dintel')->label(_('Modelo del panel'))->inline()
                                    ->options([
                                        '1' => 'Como la puerta',
                                        '2' => 'Otra opción',
                                    ])->reactive(),
                                Forms\Components\TextInput::make('descripcion_modelo_dintel')->label('Modelo del panel (Descripcion):')
                                    ->reactive()
                                    ->hidden(function (Callable $get) { return $get('modelo_dintel') == 2 ? false : true; }),
                            ])->collapsible()->collapsed(),
                            Section::make('Tubos laterales')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Opciones de los tubos laterales')
                            ->schema([
                                Forms\Components\TextInput::make('tubos_cantidad')
                                    ->label('Cantidad')
                                    ->numeric(),
                                Forms\Components\TextInput::make('tubos_alto')
                                    ->label('Alto')
                                    ->numeric(),
                                Forms\Components\TextInput::make('tubos_color')
                                    ->label('Color')
                            ])->collapsible()->collapsed(),
                            Section::make('Ventanas')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Marca aquí si incluyes ventanas')
                            ->schema([
                                Forms\Components\TextInput::make('numero_ventanas')
                                    ->label('Numero de ventanas')
                                    ->numeric(),
                                Forms\Components\ToggleButtons::make('ventana_tipo')->label(_('Tipo de ventana'))->inline()
                                    ->options([
                                        '1' => 'Residencial 520 x 350',
                                        '2' => 'Industrial 609 x 146',
                                        '3' => 'Industrial 609 x 203',
                                        '4' => 'Industrial ovalada 670 x 345',
                                    ]),
                                Forms\Components\ToggleButtons::make('ventana_tipo_cristal')->label(_('Tipo de cristal (ventana)'))->inline()
                                    ->options([
                                        '1' => 'Transparente',
                                        '2' => 'Translucida',
                                        '3' => 'Opaca',
                                    ]),
                                Forms\Components\Textarea::make('posicion_ventanas')
                                    ->label('Posición ventanas'),
                            ])->collapsible()->collapsed(),
                            Section::make('Rejillas')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->description('Marca aquí si incluyes rejillas')
                            ->schema([
                                Forms\Components\TextInput::make('numero_rejillas')
                                        ->label('Numero de rejillas')
                                        ->numeric(),
                                Forms\Components\ToggleButtons::make('rejillas_tipo')->label(_('Tipo de rejillas'))->inline()
                                        ->options([
                                            '1' => 'Estándar 337 x 131',
                                            '2' => 'Grande 500 x 330',
                                        ]),
                                Forms\Components\Textarea::make('posicion_rejillas')
                                        ->label('Posición rejillas'),
                            ])->collapsible()->collapsed(),


                            Section::make('Otras opciones')->columns(1)->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(1)) ? false : true; })
                            ->schema([
                                Forms\Components\Toggle::make('muelles_antirotura')->label(_('Muelles antirotura'))->reactive()->default(true),
                                Forms\Components\Toggle::make('soporte_guia_lateral')->label(_('Soporte guía lateral'))->reactive()->default(true),
                                Forms\Components\Toggle::make('paracaidas')->label(_('Paracaídas'))->reactive(),
                                Forms\Components\ToggleButtons::make('color_herraje_std')
                                    ->label(_('Color herrajes'))->inline()->reactive()
                                    ->options([
                                        '1' => 'Blanco (Estandard)',
                                        '2' => 'Otro color',
                                    ])->default(1),
                                Forms\Components\TextInput::make('color_herraje_no_std')
                                    ->label(_('Color herrajes no estándard'))
                                    ->hidden( function (callable $get) {
                                        return $get('color_herraje_std') == 2 ? false : true;
                                    }),
                                Forms\Components\ToggleButtons::make('color_guias_std')
                                    ->label(_('Color guias'))->inline()->reactive()
                                    ->options([
                                        '1' => 'Sin lacar (Estandard)',
                                        '2' => 'Otro color',
                                    ])->default(1),
                                Forms\Components\TextInput::make('color_guias_no_std')
                                    ->label(_('Color guias no estándard'))
                                    ->hidden( function (callable $get) {
                                        return $get('color_guias_std') == 2 ? false : true;
                                    }),
                                ]),

                            Section::make('Buzón')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,5)) ? false : true; })
                                ->description('Marca aquí si incluyes buzón')
                                ->schema([
                                    Forms\Components\Toggle::make('buzon')->label(_('Buzon'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                    Forms\Components\ToggleButtons::make('buzon_tipo')->label(_('Tipo de buzón'))->inline()
                                            ->options([
                                                '1' => 'Inox',
                                                '2' => 'Lacado RAL',
                                            ])->hidden( function (callable $get) {
                                                return !$get('buzon');
                                            }),
                                    SignaturePad::make('ubicacion_buzon')->hidden(function (callable $get) { return !$get('buzon'); }),
                                ])->collapsible()->collapsed(),

                                Section::make('Cerradura CISA Moderna')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; })
                                ->description('Marca aquí si incluyes Cerradura CISA Moderna')
                                ->schema([
                                    Forms\Components\Toggle::make('cisa_moderna')->label(_('CISA Moderna'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),

                                ])->collapsible()->collapsed(),
                                Section::make('Seguridad peatonal')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                ->description('Marca aquí si incluyes seguridad peatonal')
                                ->schema([
                                    Forms\Components\Toggle::make('seguridad_peatonal')->label(_('Seguridad peatonal'))->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                ])->collapsible()->collapsed(),
                                Section::make('Cerrojo a suelo')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                ->description('Marca aquí si incluyes cerrojo a suelo')
                                ->schema([
                                    Forms\Components\Toggle::make('cerrojo_suelo')->label(_('Cerrojo a suelo'))->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(5)) ? false : true; })
                                ])->collapsible()->collapsed(),
                                Section::make('Tirador')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(2,3,4,5)) ? false : true; })
                                ->description('Marca aquí si incluyes tirador')
                                ->schema([
                                    Forms\Components\Toggle::make('tirador')->label(_('Tirador'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                    Forms\Components\ToggleButtons::make('tipo_tirador')->label(_('Tipo de tirador'))->inline()
                                            ->options([
                                                '1' => 'Inox Mate',
                                                '2' => 'Del color de la puerta',
                                            ])->hidden( function (callable $get) {
                                                return !$get('tirador');
                                            }),
                                ])->collapsible()->collapsed(),
                                Section::make('Buzón')->hidden(function (Callable $get) { return in_array($get('puerta_id'),array(3,4)) ? false : true; })
                                ->description('Marca aquí si incluyes buzón')
                                ->schema([
                                    Forms\Components\Toggle::make('buzon')->label(_('Buzon'))->afterStateUpdated(function ($state, callable $get, callable $set) { })->reactive(),
                                    Forms\Components\ToggleButtons::make('buzon_tipo')->label(_('Tipo de buzón'))->inline()
                                            ->options([
                                                '1' => 'Inox Mate',
                                                '2' => 'Del color de la puerta',
                                            ])->hidden( function (callable $get) {
                                                return !$get('buzon');
                                            }),
                                    SignaturePad::make('ubicacion_buzon')->hidden(function (callable $get) { return !$get('buzon'); }),
                                ])->collapsible()->collapsed(),
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
                                Forms\Components\ToggleButtons::make('motor_opcion')->label('Motor')->inline()
                                        ->options([
                                            '1' => 'Se conserva motor',
                                            '2' => 'Motor nuevo',
                                        ])
                                        ->reactive()
                                        ->hidden( function (callable $get) {
                                            return $get('funcionamiento') == 2 && in_array($get('puerta_id'),array(2,3,4)) ? false : true;
                                        }),
                                Forms\Components\ToggleButtons::make('mecanismo_cierra')->label('Mecanismo de cierre')->multiple()->inline()
                                        ->options([
                                            '1' => 'Cerradura pico de loro.',
                                            '2' => 'Cerrojo a suelo',
                                            '3' => 'Cerrojo atrás',
                                            '4' => 'Candado',
                                            '5' => 'CISA moderna',
                                        ])
                                        ->reactive()
                                        ->hidden( function (callable $get) {
                                            return $get('funcionamiento') == 1 && in_array($get('puerta_id'),array(3,4)) ? false : true;
                                        }),
                                Forms\Components\Select::make('tipomotors_id')
                                    ->label('Tipo de motor')
                                    ->relationship('tipomotors','tipo_motor.nombre')
                                    ->options(function (callable $get, callable $set) {
                                        return TipoMotor::join('puerta_tipo_motor','tipo_motor.id','puerta_tipo_motor.tipo_motor_id')->where('puerta_tipo_motor.puerta_id',$get('puerta_id'))->orderBy('nombre','desc')->pluck('tipo_motor.nombre','tipo_motor.id')->toArray();
                                    })
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 2 && ($get('motor_opcion') == 2  || $get('puerta_id') == 1 ) ? false : true;
                                    })
                                    ->reactive(),
                                Forms\Components\Select::make('motors_id')
                                    ->label('Modelo de motor')
                                    ->relationship('motors','motors.nombre')
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 2 && ($get('motor_opcion') == 2  || $get('puerta_id') == 1 ) ? false : true;
                                    })
                                    ->options(function (callable $get, callable $set) {
                                        return Motor::where('tipomotors_id',$get('tipomotors_id'))->orderBy('nombre','desc')->pluck('nombre','id')->toArray();
                                    })
                                    ->reactive(),
                                Forms\Components\Repeater::make('opcionpresupuesto')
                                    ->relationship('opcionpresupuesto')
                                    ->label('Accesorios')
                                    ->schema([
                                        Forms\Components\Select::make('opcion_id')
                                            ->relationship('opcion','nombre')
                                            ->label('Accesorio'),
                                        Forms\Components\TextInput::make('valor')->label('Cantidad')
                                    ])
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 2 ? false : true;
                                    })->columns(2),

                                Forms\Components\Toggle::make('manual_tirador')
                                    ->label(_('Tirador'))
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 1 && !in_array($get('puerta_id'),array(2,3,4)) ? false : true;
                                }),
                                Forms\Components\Toggle::make('manual_cerradura_fac')
                                    ->label(_('Cerradura tipo FAC'))
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 1 && $get('puerta_id') == 1 ? false : true;
                                }),
                                Forms\Components\ToggleButtons::make('manual_cerradura_pc')
                                    ->label(_('Mecanismo de cierre'))
                                    ->multiple()
                                    ->options([
                                        '1' => 'Cerradura pico de loro.',
                                        '2' => 'Cerrojo a suelo',
                                        '3' => 'Cerrojo atrás',
                                        '4' => 'Candado',
                                    ])
                                    ->hidden( function (callable $get) {
                                        return $get('funcionamiento') == 1 && in_array($get('puerta_id'),array(2))  ? false : true;
                                }),
                                Forms\Components\Select::make('manillas')->hidden(function (Callable $get) { return $get('funcionamiento') == 1 && in_array($get('puerta_id'),array(2,3,4)) ? false : true; })
                                    ->label('Manillas')
                                    ->options([
                                        '1' => 'Sin manillas',
                                        '2' => 'Sólo manilla exterior',
                                        '3' => 'Sólo manilla interior',
                                        '4' => 'Con manillas interior y exterior',
                                    ])->reactive(),
                            ])->collapsible(),
                    ]),
                Wizard\Step::make('Datos para montaje y fabricación')
                ->schema([
                    Section::make('Datos para montaje')
                        ->schema([
                            Grid::make()->schema([
                                Forms\Components\Toggle::make('electricidad')->label(_('Electricidad'))->reactive(),
                                Forms\Components\ToggleButtons::make('responsable_elect')->reactive()->inline()->label('Responsable tareas electricidad')
                                ->options([
                                    '1' => 'Portagal',
                                    '2' => 'Cliente',
                                ])->hidden(fn(Callable $get) => !$get('electricidad') ),
                                Forms\Components\Textarea::make('electricidad_comentarios')
                                    ->label('Tareas a realizar de electricidad')
                                    ->hidden(fn(Callable $get) => (!$get('responsable_elect') == 1 || !$get('responsable_elect') == 2) || !$get('electricidad') != false ),

                                Forms\Components\Toggle::make('obras')->label(_('Albañilería'))->reactive(),
                                Forms\Components\ToggleButtons::make('responsable_obras')->reactive()->inline()->label('Responsable tareas albañilería')
                                ->options([
                                    '1' => 'Portagal',
                                    '2' => 'Cliente',
                                ])->hidden(fn(Callable $get) => !$get('obras') ),
                                Forms\Components\Textarea::make('obras_comentarios')
                                    ->label('Tareas a realizar de albañilería')
                                    ->hidden(fn(Callable $get) => (!$get('responsable_obras') == 1 || !$get('responsable_obras') == 2) || !$get('obras') != false ),

                            ])->columns(1),
                            Section::make('Materiales')->schema([
                            Grid::make()->label('Materiales')->schema([
                                Forms\Components\Select::make('materiales_pilar_izquierdo')
                                    ->label('Pilar izquierdo (vista exterior)')
                                    ->reactive()
                                    ->options(Material::pluck('nombre','id')->toArray()),
                                Forms\Components\Select::make('materiales_pilar_derecho')
                                    ->label('Pilar derecho (vista exterior)')
                                    ->options(Material::pluck('nombre','id')->toArray()),
                                Forms\Components\Select::make('materiales_techo_anclaje')
                                    ->label('Techo o anclaje superior')
                                    ->options(Material::pluck('nombre','id')->toArray()),
                                Forms\Components\Textarea::make('materiales_comentarios')
                                    ->label('Observaciones de materiales')

                            ])->columns(1),
                            ]),
                            Section::make('Medidas de obra (en mm.)')->schema([
                                Grid::make()->label('Materiales')->schema([
                                    Forms\Components\TextInput::make('distancia_paredes')->label('Distancia entre paredes')->numeric(),
                                    Forms\Components\TextInput::make('altura_hasta_techo')->label('Altura hasta techo')->numeric(),
                                ])->columns(1),
                            ]),
                            Grid::make()->schema([
                                Forms\Components\Toggle::make('elevador')->label(_('Elevador'))->reactive(),
                                Forms\Components\ToggleButtons::make('responsable_elevador')->reactive()->inline()->label('Responsable Elevador')
                                ->options([
                                    '1' => 'Portagal',
                                    '2' => 'Cliente',
                                ])->hidden(fn(Callable $get) => !$get('elevador') ),
                                Forms\Components\Select::make('elevador_id')
                                    ->relationship('elevadors','nombre')
                                    ->label('Tipo de elevador:')
                                    ->hidden(fn(Callable $get) => (!$get('responsable_elevador') == 1 || !$get('responsable_elevador') == 2) || !$get('elevador') != false ),
                            ])->columns(1),
                        ]),
                    Section::make('Datos para fabricación')
                        ->schema([
                            Forms\Components\Toggle::make('sw_croquis_1')->label(_('Croquis 1'))->reactive(),
                            SignaturePad::make('croquis_1')->label(_('Croquis 1'))->hidden(fn(Callable $get) => !$get('sw_croquis_1') ),
                            Forms\Components\Toggle::make('sw_croquis_2')->label(_('Croquis 2'))->reactive(),
                            SignaturePad::make('croquis_2')->label(_('Croquis 2'))->hidden(fn(Callable $get) => !$get('sw_croquis_2') ),
                            Forms\Components\Toggle::make('sw_batiente_1')->label(_('Batiente 1'))->reactive(),
                            SignaturePad::make('batiente_1')->label(_('Batiente 1'))->hidden(fn(Callable $get) => !$get('sw_batiente_1') ),
                            Forms\Components\Toggle::make('sw_batiente_2')->label(_('Batiente 2'))->reactive(),
                            SignaturePad::make('batiente_2')->label(_('Batiente 2'))->hidden(fn(Callable $get) => !$get('sw_batiente_2') ),
                            Forms\Components\Toggle::make('sw_orejetas')->label(_('Orejetas'))->reactive(),
                            SignaturePad::make('orejetas_1')->label(_('Orejetas'))->hidden(fn(Callable $get) => !$get('sw_orejetas') ),
                            Forms\Components\Toggle::make('sw_remate_1')->label(_('Remate 1'))->reactive(),
                            SignaturePad::make('remate_1')->label(_('Remate 1'))->hidden(fn(Callable $get) => !$get('sw_remate_1') ),
                            Forms\Components\Toggle::make('sw_remate_2')->label(_('Remate 2'))->reactive(),
                            SignaturePad::make('remate_2')->label(_('Remate 2'))->hidden(fn(Callable $get) => !$get('sw_remate_2') ),
                            Forms\Components\Toggle::make('sw_poste_1')->label(_('Poste 1'))->reactive(),
                            SignaturePad::make('poste_1')->label(_('Poste 1'))->hidden(fn(Callable $get) => !$get('sw_poste_1') ),
                            Forms\Components\Toggle::make('sw_poste_2')->label(_('Poste 2'))->reactive(),
                            SignaturePad::make('poste_2')->label(_('Poste 2'))->hidden(fn(Callable $get) => !$get('sw_poste_2') ),
                            Forms\Components\Toggle::make('sw_poste_3')->label(_('Poste 3'))->reactive(),
                            SignaturePad::make('poste_3')->label(_('Poste 3'))->hidden(fn(Callable $get) => !$get('sw_poste_3') ),
                            Forms\Components\Toggle::make('sw_u_de_cierre')->label(_('U de Cierre'))->reactive(),
                            SignaturePad::make('u_de_cierre')->label(_('U de Cierre'))->hidden(fn(Callable $get) => !$get('sw_u_de_cierre') ),
                            Forms\Components\Toggle::make('sw_portico')->label(_('Pórtico'))->reactive(),
                            SignaturePad::make('portico')->label(_('Pórtico'))->hidden(fn(Callable $get) => !$get('sw_portico') ),
                            Forms\Components\Toggle::make('sw_tope_suelo')->label(_('Tope de suelo'))->reactive(),
                            SignaturePad::make('tope_suelo')->label(_('Tope de suelo'))->hidden(fn(Callable $get) => !$get('sw_tope_suelo') ),
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
                        //DibujoField::make('firma'),
                ]),
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
