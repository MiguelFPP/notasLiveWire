<div class="py-4">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
        @forelse ($notes as $note)
            <div class="p-6 sm:max-w-sm bg-white rounded-lg border border-gray-200 shadow-md mx-2 sm:mx-0">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">
                        @if ($note->title)
                            {{ $note->title }}
                        @else
                            No tiene Titulo
                        @endif
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">{{ Str::limit($note->content, 50) }}</p>

                <div class="flex justify-end mt-5">
                    <a href="{{ route('note.edit', $note) }}"
                        class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-2">
                        Editar
                        <i class="fa-solid fa-pencil ml-1"></i>
                    </a>
                    <button wire:click="$emit('delete', {{ $note->id }})"
                        class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Eliminar
                        <i class="fa-solid fa-trash ml-1"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center">
                <h3 class="text-gray-500">No hay notas</h3>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('delete', (note_id) => {
            Swal.fire({
                title: 'Estas Seguro?',
                text: "No podra revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    /* eliminar nota */
                    Livewire.emit('deleteNote', note_id)
                    Swal.fire(
                        'Eliminada!',
                        'La nota ha sido eliminada.',
                        'success'
                    )
                }
            })
        });
    </script>
@endpush
