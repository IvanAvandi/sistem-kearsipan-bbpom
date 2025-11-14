<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="['Usulan Pindah' => route('admin.usul-pindah-review.index')]" icon="usulan_pindah"/>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            {{-- Panggil komponen Livewire yang menampilkan tabel --}}
            @livewire('admin.usulan-pindah-table')
        </div>
    </div>
</x-app-layout>