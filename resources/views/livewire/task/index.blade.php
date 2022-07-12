<div>
    <div>
        {{-- form with a input and button --}}
        <form wire:submit.prevent="taskSave">
            @csrf
            <div class="grid grid-cols-1">
                <div class="flex">
                    <input type="text" wire:model="content" class="w-full border-2 border-gray-300 rounded-lg p-2"
                        placeholder="{{ __('Nueva Tarea') }}">
                    <x-jet-button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg ml-2">
                        {{ __('Agregar') }}
                    </x-jet-button>
                </div>
                @error('content')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
    <div class="grid grid-cols-1 mt-3">
        <div class="p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md mx-4 md:mx-3">
            <div class="flex flex-col items-center w-full">
                @forelse ($tasks as $task)
                    <div class="flex justify-between bg-gray-200 shadow-md rounded-lg mb-2 w-full">
                        <input type="checkbox" name="" id=""
                            class="order-1 border-gray-300 rounded-lg mx-3 my-4"
                            @if ($task->complete) checked @endif
                            wire:click="taskCompleted({{ $task->id }})">
                        <p class="order-2 text-md font-bold @if ($task->complete) line-through @endif my-3">
                            {{ $task->content }}
                        </p>
                        <x-jet-button class="order-3 ml-4" wire:click="delete({{ $task->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </x-jet-button>
                    </div>
                @empty
                    <div class="text-center">
                        <h3 class="text-gray-500">{{ __('No hay tareas') }}</h3>
                        <p class="text-gray-500">{{ __('Agrega una tarea para empezar') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
