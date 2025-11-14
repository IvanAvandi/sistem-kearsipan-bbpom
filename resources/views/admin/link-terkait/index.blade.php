<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Pengaturan' => route('admin.pengaturan.index'), 
            'Link Terkait' => route('admin.link-terkait.index')
        ]" />
    </x-slot>

{{--     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:admin.link-terkait-table />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>