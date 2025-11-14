<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="['Daftar Arsip' => route('arsip.index'), 'Tambah Arsip' => '#']" />
    </x-slot>

{{--     <div class="py-12"> --}}
{{--         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}

            @if(isset($isDuplicate) && $isDuplicate)
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                <p class="font-bold">Mode Duplikasi</p>
                <p>Anda sedang menduplikasi data arsip. Silakan periksa dan ubah data yang diperlukan sebelum menyimpan.</p>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('arsip._form')
                    </form>
                </div>
            </div>
{{--          </div> --}}
{{--      </div> --}}
</x-app-layout>