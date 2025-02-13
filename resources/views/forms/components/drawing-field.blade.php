<div
    wire:ignore
    x-data
    x-init="
        setTimeout(() => {
            const instance = new tui.ImageEditor($refs.editor, {
                includeUI: {
                    loadImage: { path: '', name: 'Dibujo' },
                    theme: {},
                    menu: ['shape', 'text', 'draw', 'filter'],
                    initMenu: 'draw',
                    uiSize: { width: '100%', height: '500px' },
                    menuBarPosition: 'bottom'
                },
                cssMaxWidth: 700,
                cssMaxHeight: 500,
                selectionStyle: { cornerSize: 10, rotatingPointOffset: 20 }
            });

            // Guardar la imagen en Base64 cuando se edite
            instance.on('objectAdded', () => {
                @this.set('{{ $getStatePath() }}', instance.toDataURL());
            });

        }, 500);
    "
>
    <div x-ref="editor"></div>
</div>
