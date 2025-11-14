<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="['Pengaturan' => route('admin.pengaturan.index'), 'Pengguna' => '#']" icon="pengaturan" />
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @livewire('admin.user-table')
        </div>
    </div>
</x-app-layout>