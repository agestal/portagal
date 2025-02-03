<div x-data="{
    canvas: null,
    init() {
        this.$nextTick(() => {
            const canvasElement = this.$refs.canvas;
            if (canvasElement) {
                // Inicializa Fabric.js en el canvas
                this.canvas = new fabric.Canvas(canvasElement);
                this.canvas.isDrawingMode = true; // Activa el modo de dibujo
                this.canvas.freeDrawingBrush.width = 5;
                this.canvas.freeDrawingBrush.color = '#000000';
            } else {
                console.error('No se encontró el elemento canvas');
            }
        });
    },
    changeColor(color) {
        if (this.canvas) {
            this.canvas.freeDrawingBrush.color = color;
        }
    },
    changeWidth(width) {
        if (this.canvas) {
            this.canvas.freeDrawingBrush.width = width;
        }
    },
    saveDrawing() {
        if (this.canvas) {
            const dataURL = this.canvas.toDataURL();
            this.$refs.hiddenInput.value = dataURL; // Guarda la imagen en base64
        }
    }
}" x-init="init()">
    <div class="flex space-x-4">
        <!-- Botones para cambiar el color del pincel -->
        <button @click="changeColor('#ff0000')" style="background-color: red;" class="p-2 rounded"></button>
        <button @click="changeColor('#00ff00')" style="background-color: green;" class="p-2 rounded"></button>
        <button @click="changeColor('#0000ff')" style="background-color: blue;" class="p-2 rounded"></button>

        <!-- Botones para cambiar el grosor del pincel -->
        <button @click="changeWidth(5)" class="p-2 border rounded">Grosor 5px</button>
        <button @click="changeWidth(10)" class="p-2 border rounded">Grosor 10px</button>
    </div>

    <!-- Canvas para el dibujo -->
    <canvas x-ref="canvas" width="600" height="400" class="border border-gray-300 mt-4"></canvas>

    <!-- Botón para guardar el dibujo -->
    <button @click="saveDrawing" class="mt-4 p-2 bg-blue-500 text-white rounded">Guardar</button>

    <!-- Input oculto para enviar la imagen en base64 -->
    <input type="hidden" name="data.drawing" x-ref="hiddenInput">
</div>
