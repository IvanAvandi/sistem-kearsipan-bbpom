<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Pengaturan' => route('admin.pengaturan.index'), 
            'Klasifikasi Surat' => route('admin.klasifikasi.index')
        ]" />
    </x-slot>

{{--     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- File ini HANYA memanggil komponen Livewire. Tabel dan logika ada di dalam komponen. --}}
                    <livewire:admin.klasifikasi-table />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>