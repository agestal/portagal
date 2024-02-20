<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body>
    <header>
    </header>
     @foreach ( $record->archivo1 as $f )   
    <p> <img src='{{ asset("/images/".$f) }}'> </img> </p>
    @endforeach
    <p>ID: {{ $record->id }}</p>
    <p>Puerta: {{ $record->puertas->nombre }}</p>
    <p>Material: {{ $record->panels->nombre }}</p>
    <p>Color: {{ $record->colorpanels->nombre }}</p>
    <p>Fecha: {{ $record->created_at }}</p>

    <p> <img src='{{ $record->firma }}'> </img> </p>
</body>
</html>


