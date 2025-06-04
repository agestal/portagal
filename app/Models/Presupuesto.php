<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Znck\Eloquent\Relations\BelongsToThrough;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;

class Presupuesto extends Model
{
    use HasFactory, InteractsWithMaps;
    protected static ?string $modeLabel = "Medicion";
    protected static ?string $pluralModelLabel = "Mediciones";
    protected static ?string $navigationLabel = "Mediciones";
    protected $fillable = [
        'fecha',
        'nombre_cliente',
        'email',
        'referencia',

        'puerta_id',

        'panel_id',
        'colorpanel_id',
        'tipo_color_panel',
        'colorpanel_no_std',

        'puertamaterial_id',

        'tipo_suelo',
        'suelocc_anchod',
        'suelocc_anchoi',
        'suelocc_alto',
        'suelocc_dintel',
        'sueloh_alto',
        'sueloh_ancho',
        'sueloh_dintel',
        'techo_inclinacion',
        'grados_inclinacion',

        'dintel_panel' ,
        'dintel_ancho',
        'dintel_alto' ,

        'tubos_laterales',
        'tubos_cantidad',
        'tubos_alto',
        'tubos_color',

        'ventanas',
        'ventanas_tipo',
        'ventanas_tipo_cristal',
        'numero_ventanas',
        'posicion_ventanas',

        'rejillas',
        'numero_rejillas',
        'posicion_rejillas',

        'muelles_antirotura',
        'color_herraje_std',
        'color_herraje_no_std',

        'soporte_guia_lateral',
        'color_guias_std',
        'color_guias_no_std',
        'paracaidas',

        'peatonal_insertada',
        'peatonal_apertura',
        'peatonal_posicion',
        'peatonal_bisagras',
        'peatonal_cierrapuertas',
        'peatonal_seguridad',

        'funcionamiento',
        'tipomotors_id',
        'motors_id',
        'manual',
        'manual_tirador',

        'electricidad',
        'electricidad_comentarios',
        'obras',
        'obras_comentarios',
        'distancia_vertical',
        'distancia_horizontal',
        'elevador',
        'elevador_portagal',

        'firma',
        'montaje_guias',
        'renates',
        'portico',

        'location',
        'full_address',
        'lat',
        'lon',

        'fotos',
        'comentarios_fotos',

        'comentarios',
        'observaciones',
        'mecanismo_cierra',
        'manual_cerradura_pc',
        'manual_cerradura_fac',
        'manual_tirador',
        'tipo_vivienda',
        'ancho_pilares',
        'tirador',
        'tipo_tirador',
        'mecanismo_cierra',
        'seguridad_peatonal',
        'cerrojo_suelo',
        'dibujo_peatonal',
        'montaje_guia_suelo',
        'material_guia_suelo_cr',
        'materiales_comentarios',
        'materiales_pilares',
        'materiales_techo',
        'montaje_guia_suelo',
        'material_guia_suelo_cr',
        'distancia_paredes',
        'color_herraje_std',
        'color_herraje_no_std',
        'color_panel_std',
        'color_panel_no_std',
        'color_panel',
    ];
    protected $casts = [
        'fotos' => 'array',
        'mecanismo_cierra' => 'array',
        'manual_cerradura_pc' => 'array',
        'location' => 'array',
        'fecha' => 'datetime',
    ];
    protected $appends = [
        'location',
    ];
    public function getLocationAttribute(): array
    {
        return [
            "lat" => (float)$this->lat,
            "lng" => (float)$this->lon,
        ];
    }
    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location))
        {
            $this->attributes['lat'] = $location['lat'];
            $this->attributes['lon'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }
    public static function getComputedLocation(): string
    {
        return 'location';
    }

    public function puertas() : BelongsTo
    {
        return $this->belongsTo(Puerta::class, 'puerta_id' , 'id');
    }
    public function puertamaterials() : BelongsTo
    {
        return $this->belongsTo(Puertamaterial::class,'puertamaterial_id','id');
    }
    public function panels() : BelongsTo
    {
        return $this->belongsTo(Panel::class, 'panel_id', 'id');
    }
    public function colorpanels() : BelongsTo
    {
        return $this->belongsTo(Colorpanel::class, 'colorpanel_id', 'id');
    }
    public function opcionpresupuesto(): HasMany
    {
        return $this->hasMany(OpcionPresupuesto::class);
    }
    public function motors()  : BelongsTo
    {
        return $this->belongsTo(Motor::class);
    }
    public function elevadors()  : BelongsTo
    {
        return $this->belongsTo(Elevador::class);
    }
    public function tipomotors() : BelongsTo
    {
        return $this->belongsTo(TipoMotor::class);
    }
    /*use \Znck\Eloquent\Traits\BelongsToThrough;
    public function colors() : BelongsToThrough
    {
        return $this->belongsToThrough(
            Color::class,
            [ColorMaterial::class, Material::class],
            foreignKeyLookup: [
                ColorMaterial::class => 'id',
                Material::class => 'material_id'
            ],
            localKeyLookup: [
                Material::class => 'id',
                Color::class => 'id'
            ]
        );
    }*/
}
