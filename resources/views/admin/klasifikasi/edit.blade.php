<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Pengaturan' => route('admin.pengaturan.index'), 
            'Klasifikasi Surat' => route('admin.klasifikasi.index'),
            'Edit' => '#'
        ]" />
    </x-slot>

{{--     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.klasifikasi.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.klasifikasi._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>