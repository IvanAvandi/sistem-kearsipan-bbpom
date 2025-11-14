<x-app-layout>
    <x-slot name="header">
        {{-- Ikon 'inbox-in' untuk Usul Pindah --}}
        <x-breadcrumbs :links="['Usul Pindah' => route('usul-pindah.index')]" icon="musnah" />
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            {{-- Panggil komponen Livewire yang tadi kita buat --}}
            @livewire('usulan-pindah-list')
        </div>
    </div>
</x-app-layout>