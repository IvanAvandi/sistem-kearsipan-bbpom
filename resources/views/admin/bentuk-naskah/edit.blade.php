<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Pengaturan' => route('admin.pengaturan.index'), 
            'Bentuk Naskah' => route('admin.bentuk-naskah.index'),
            'Edit' => '#'
        ]" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.bentuk-naskah.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.bentuk-naskah._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>