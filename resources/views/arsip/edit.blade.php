<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="['Daftar Arsip' => route('arsip.index'), 'Edit' => '#']" />
    </x-slot>

{{--     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Kita akan gunakan form yang sama dengan create, tapi dengan data yang sudah ada --}}
                        @include('arsip._form', ['arsip' => $arsip, 'klasifikasi_list' => $klasifikasi_list])
                    </form>
                </div>
            </div>
{{--         </div>
    </div>  --}}
</x-app-layout>