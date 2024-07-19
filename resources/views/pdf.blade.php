<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body>
    <header>
    </header>
    @foreach ( $record->fotos as $f )
    <p> <img src='{{ asset("/images/".$f) }}'> </img> </p>
    @endforeach
    <p>ID: {{ $record->id }}</p>

    <p>Cliente: {{ $record->nombre_cliente }}</p>
    <p>Referencia: {{ $record->referencia }}</p>
    <p>Email: {{ $record->email }}</p>

    <p>Puerta: {{ $record->puertas->nombre }}</p>



    <p>Fecha: {{ $record->created_at }}</p>

    <p> <img src='{{ $record->firma }}'> </img> </p>
</body>
</html>


