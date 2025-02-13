<div
    x-data="diagramEditor($wire, '{{ $getState() }}')"
    x-init="initDiagram()"
    class="border border-gray-300 rounded p-2 w-full h-96"
>
    <div id="diagram-container" class="w-full h-full"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.6.2/joint.min.js"></script>
<script>
    function diagramEditor($wire, initialState) {
        return {
            graph: null,
            paper: null,

            initDiagram() {
                this.graph = new joint.dia.Graph();

                this.paper = new joint.dia.Paper({
                    el: document.getElementById('diagram-container'),
                    model: this.graph,
                    width: '100%',
                    height: '100%',
                    gridSize: 10,
                    drawGrid: true,
                });

                if (initialState) {
                    this.graph.fromJSON(JSON.parse(initialState));
                }

                this.graph.on('change', () => {
                    $wire.set('state', JSON.stringify(this.graph.toJSON()));
                });
            }
        };
    }
</script>
