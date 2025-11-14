<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Usul Musnah' => route('admin.usulan-pemusnahan.index')
            ]" icon="musnah" />
    </x-slot>

{{--    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
            @livewire('admin.usulan-pemusnahan-table')
        </div>
    </div>
</x-app-layout>