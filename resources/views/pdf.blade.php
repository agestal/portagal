
<div>ID: {{ $record->id }}</div>

<div>Puerta: {{ $record->puertas->nombre }}</div>
<div>Material: {{ $record->panels->nombre }}</div>
<div>Color: {{ $record->colorpanels->nombre }}</div>
<div>Fecha: {{ $record->created_at }}</div>
<div>Imagen 1: <img src='{{ asset("/images/".$record->archivo1) }}'> </img> </div>
