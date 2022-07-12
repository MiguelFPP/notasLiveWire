<div class="flex flex-col w-full">
    <form action="" class="" wire:submit.prevent="save">
        @csrf
        <div class="mb-3">
            <x-jet-label for="titulo" :value="__('Titulo Nota')" />

            <x-jet-input wire:model="title" name="title" class="block mt-1 w-full" type="text" :value="old('title')"
                placeholder="Titulo Nota" />
        </div>
        <div wire:ignore x-data="{ content: @entangle('content') }" x-init="ClassicEditor
            .create($refs.ckeditor, {
                extraPlugins: [MyCustomUploadAdapterPlugin],
            }).then(editor => {
                editor.model.document.on('change:data', () => {
                    content = editor.getData()
                });
            })
            .catch(error => {
                console.error(error);
            });">
            <div x-ref="ckeditor">
                {!! $this->content !!}
            </div>
        </div>
        <x-jet-button class="mt-3">
            Guardar Nota
        </x-jet-button>
    </form>
</div>
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /* alerta */
        Livewire.on('noteUpdated', () => {
            Swal.fire(
                'Ediatado!',
                'La nota ha sido Editada.',
                'success'
            )
        });
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }
            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('images.upload') }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    /* almacenar el path de la imagen en el componenet livewire */
                    @this.addImage(response.path)

                    resolve({
                        default: response.url
                    });
                });
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();

                /* nombre de donde se almacena la imagen para el backend */
                data.append('upload', file);
                this.xhr.send(data);
            }

        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }
    </script>
@endpush
