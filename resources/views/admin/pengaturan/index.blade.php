<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :links="['Pengaturan' => route('admin.pengaturan.index')]" icon="pengaturan" />
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card Klasifikasi Surat --}}
        <a href="{{ route('admin.klasifikasi.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                </div>
                <div>
                    <h5 class="text-lg font-bold tracking-tight text-gray-900">Klasifikasi Surat</h5>
                    <p class="text-sm font-normal text-gray-600">Kelola kode dan retensi.</p>
                </div>
            </div>
        </a>

        {{-- Card Bentuk Naskah --}}
        <a href="{{ route('admin.bentuk-naskah.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                <div>
                    <h5 class="text-lg font-bold tracking-tight text-gray-900">Bentuk Naskah</h5>
                    <p class="text-sm font-normal text-gray-600">Kelola jenis dokumen.</p>
                </div>
            </div>
        </a>

        {{-- Card Link Terkait --}}
        <a href="{{ route('admin.link-terkait.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 text-yellow-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold tracking-tight text-gray-900">Link Terkait</h5>
                        <p class="text-sm font-normal text-gray-600">Kelola tautan pintas.</p>
                    </div>
                </div>
        </a>

        {{-- Card Format TND --}}
        <a href="{{ route('admin.templates.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                    </div>
                </div>
                <div>
                    <h5 class="text-lg font-bold tracking-tight text-gray-900">Format TND</h5>
                    <p class="text-sm font-normal text-gray-600">Kelola Format Tata Naskah Dinas.</p>
                </div>
            </div>
        </a>
        
        {{-- Card Pengguna --}}
        <a href="{{ route('admin.users.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h5 class="text-lg font-bold tracking-tight text-gray-900">Pengguna</h5>
                    <p class="text-sm font-normal text-gray-500">Lihat daftar pengguna dan role mereka.</p>
                </div>
            </div>
        </a>
        
        {{-- Card Subkelompok Surat (Disabled) --}}
        <div class="block p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-md cursor-not-allowed opacity-60">
                 <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-gray-200 text-gray-500">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold tracking-tight text-gray-600">Subkelompok Surat</h5>
                        <p class="text-sm font-normal text-gray-500">(Belum diaktifkan).</p>
                    </div>
                </div>
        </div>

    </div>
</x-app-layout>