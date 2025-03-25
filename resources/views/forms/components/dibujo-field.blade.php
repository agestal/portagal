<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
<div>
    <canvas width="500" height="500" style="border:1px solid #000000;">
    </canvas>
    <button type="button" onclick="setDrawingMode('line')">Draw Line</button>
    <button type="button" onclick="setDrawingMode('rect')">Draw Rectangle</button>
    <button type="button" onclick="setDrawingMode('circle')">Draw Circle</button>
    <button type="button" onclick="setDrawingMode('freehand')">Freehand Drawing</button>
    <button type="button" onclick="clearCanvas()">Clear Canvas</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = new fabric.Canvas('data.firma');

        // Modo de dibujo (por defecto: línea)
        var drawingMode = 'line';
        var isDrawing = false;
        var startPoint = null;
        var freehandPath = null;

        // Función para establecer el modo de dibujo
        window.setDrawingMode = function(mode) {
            drawingMode = mode;
            canvas.selection = false; // Desactiva la selección de objetos
            canvas.forEachObject(function(obj) {
                obj.selectable = false;
            });

            // Si el modo es "freehand", activa el dibujo a mano alzada
            if (mode === 'freehand') {
                canvas.isDrawingMode = true;
            } else {
                canvas.isDrawingMode = false;
            }
        };

        // Función para limpiar el canvas
        window.clearCanvas = function() {
            canvas.clear();
        };

        // Evento cuando se hace clic en el canvas
        canvas.on('mouse:down', function(options) {
            if (drawingMode && drawingMode !== 'freehand') {
                isDrawing = true;
                startPoint = options.pointer;
            }
        });

        // Evento cuando se mueve el mouse
        canvas.on('mouse:move', function(options) {
            if (!isDrawing || drawingMode === 'freehand') return;

            var pointer = options.pointer;

            if (drawingMode === 'line') {
                // Dibujar una línea temporal
                canvas.clearContext(canvas.contextTop);
                canvas.renderAll();

                new fabric.Line([startPoint.x, startPoint.y, pointer.x, pointer.y], {
                    stroke: 'black',
                    strokeWidth: 2,
                    selectable: false
                }).render(canvas.contextTop);
            } else if (drawingMode === 'rect') {
                // Dibujar un rectángulo temporal
                canvas.clearContext(canvas.contextTop);
                canvas.renderAll();

                var width = pointer.x - startPoint.x;
                var height = pointer.y - startPoint.y;

                new fabric.Rect({
                    left: startPoint.x,
                    top: startPoint.y,
                    width: width,
                    height: height,
                    stroke: 'black',
                    strokeWidth: 2,
                    fill: 'transparent',
                    selectable: false
                }).render(canvas.contextTop);
            } else if (drawingMode === 'circle') {
                // Dibujar un círculo temporal
                canvas.clearContext(canvas.contextTop);
                canvas.renderAll();

                var radius = Math.sqrt(
                    Math.pow(pointer.x - startPoint.x, 2) +
                    Math.pow(pointer.y - startPoint.y, 2)
                );

                new fabric.Circle({
                    left: startPoint.x,
                    top: startPoint.y,
                    radius: radius,
                    stroke: 'black',
                    strokeWidth: 2,
                    fill: 'transparent',
                    selectable: false
                }).render(canvas.contextTop);
            }
        });

        // Evento cuando se suelta el mouse
        canvas.on('mouse:up', function(options) {
            if (!isDrawing || drawingMode === 'freehand') return;

            var pointer = options.pointer;

            if (drawingMode === 'line') {
                // Agregar la línea al canvas
                canvas.add(new fabric.Line([startPoint.x, startPoint.y, pointer.x, pointer.y], {
                    stroke: 'black',
                    strokeWidth: 2,
                    selectable: false
                }));
            } else if (drawingMode === 'rect') {
                // Agregar el rectángulo al canvas
                var width = pointer.x - startPoint.x;
                var height = pointer.y - startPoint.y;

                canvas.add(new fabric.Rect({
                    left: startPoint.x,
                    top: startPoint.y,
                    width: width,
                    height: height,
                    stroke: 'black',
                    strokeWidth: 2,
                    fill: 'transparent',
                    selectable: false
                }));
            } else if (drawingMode === 'circle') {
                // Agregar el círculo al canvas
                var radius = Math.sqrt(
                    Math.pow(pointer.x - startPoint.x, 2) +
                    Math.pow(pointer.y - startPoint.y, 2)
                );

                canvas.add(new fabric.Circle({
                    left: startPoint.x,
                    top: startPoint.y,
                    radius: radius,
                    stroke: 'black',
                    strokeWidth: 2,
                    fill: 'transparent',
                    selectable: false
                }));
            }

            // Reiniciar el estado de dibujo
            isDrawing = false;
            startPoint = null;
            canvas.clearContext(canvas.contextTop);
            canvas.renderAll();
        });

        // Guardar el dibujo en un campo oculto del formulario
        canvas.on('object:modified', function() {
            var data = JSON.stringify(canvas);
            document.getElementById('drawingData').value = data;
        });
    });
</script>

<input type="hidden" id="drawingData" name="{{ $getName() }}">
</x-dynamic-component>
