<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notas') }}
            </h2>
            <div class="order-last">
                <a href="{{route('note.create')}}"
                    class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                    Agregar
                    <i class="fa-solid fa-plus ml-2"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6  overflow-hidden">
            <livewire:note.index />
        </div>
    </div>
</x-app-layout>
