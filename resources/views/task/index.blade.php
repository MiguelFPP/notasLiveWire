<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista Tareas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6  overflow-hidden">
            <livewire:task.index />
        </div>
    </div>
</x-app-layout>
