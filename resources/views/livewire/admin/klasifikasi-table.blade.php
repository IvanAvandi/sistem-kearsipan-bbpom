<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    {{-- ====================================================== --}}
    {{-- == JUDUL HALAMAN (PAGE HEADER)                      == --}}
    {{-- ====================================================== --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Klasifikasi Surat</h2>
        <p class="mt-1 text-base text-gray-500">Kelola kode klasifikasi, retensi, dan keamanan arsip sesuai peraturan</p>
    </div>

    {{-- ====================================================== --}}
    {{-- == KONTROL PENCARIAN & AKSI                         == --}}
    {{-- ====================================================== --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div class="relative w-full sm:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <x-input type="text" wire:model.debounce.300ms="search" placeholder="Cari kode atau nama..." class="pl-10 w-full" />
        </div>
        
        <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0 w-full sm:w-auto">
            <button wire:click="export" 
                    class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" /><path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" /></svg>
                Ekspor
            </button>
            <button wire:click.prevent="openImportModal" 
                    class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" /></svg>
                Impor
            </button>
            <a href="{{ route('admin.klasifikasi.create') }}" 
               class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                Tambah Klasifikasi
            </a>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- == NOTIFIKASI (ALERT)                               == --}}
    {{-- ====================================================== --}}
    @if (session()->has('success'))
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">{{ session('error') }}</div>
    @endif
    @if (session()->has('import_errors'))
        <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <p class="font-bold">Terjadi kesalahan saat impor. Silakan periksa file Anda dan coba lagi.</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach(session('import_errors') as $failure)
                    <li>Baris {{ $failure->row() }}: {{ implode(', ', $failure->errors()) }} (Nilai: {{ $failure->values()[$failure->attribute()] ?? '' }})</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ====================================================== --}}
    {{-- == TABEL DATA KLASIFIKASI                           == --}}
    {{-- ====================================================== --}}
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-16 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">No.</th>
                    <th class="w-32 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Kode</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nama Klasifikasi</th>
                    <th class="w-48 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Retensi</th>
                    <th class="w-40 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Keamanan</th>
                    <th class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($items as $item)
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ $loop->iteration + $items->firstItem() - 1 }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $item->kode_klasifikasi }}</td>
                        
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-normal break-words">
                            {{ $item->nama_klasifikasi }}
                        </td>
                        
                        <td class="px-4 py-3 text-sm text-gray-700 text-center">
                            Aktif: {{ $item->masa_aktif }} th, Inaktif: {{ $item->masa_inaktif }} th
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">
                             <span class="inline-flex justify-center items-center px-2.5 py-0.5 text-xs font-medium rounded-full w-36
                                @switch($item->klasifikasi_keamanan)
                                    @case('Biasa/Terbuka') bg-blue-100 text-blue-800 @break
                                    @case('Terbatas') bg-yellow-100 text-yellow-800 @break
                                    @case('Rahasia') bg-red-100 text-red-800 @break
                                    @case('Sangat Rahasia') bg-purple-100 text-purple-800 @break
                                @endswitch">{{ $item->klasifikasi_keamanan }}
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center items-center space-x-4">
                                <a href="{{ route('admin.klasifikasi.edit', $item->id) }}" title="Edit" class="text-gray-500 hover:text-indigo-600">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                </a>
                                <button wire:click.prevent="delete({{ $item->id }})" onclick="confirm('Anda yakin ingin menghapus data ini?') || event.stopImmediatePropagation()" title="Hapus" class="text-gray-500 hover:text-red-600">
                                     <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- ====================================================== --}}
    {{-- == PAGINASI                                         == --}}
    {{-- ====================================================== --}}
    <div class="mt-4">
        {{ $items->links() }}
    </div>

    {{-- ====================================================== --}}
    {{-- == MODAL IMPOR                                      == --}}
    {{-- ====================================================== --}}
    <div x-data="{ show: @entangle('showImportModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Impor Data Klasifikasi</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Unggah file CSV atau XLSX dengan header:
                    <code class="text-xs bg-gray-100 p-1 rounded">kode_klasifikasi, nama_klasifikasi, masa_aktif, masa_inaktif, status_akhir, klasifikasi_keamanan, hak_akses, unit_pengolah</code>
                </p>
                <div class="mt-4">
                    <input type="file" wire:model="file_import" id="file_import" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div wire:loading wire:target="file_import" class="text-sm text-gray-500 mt-1">Mengunggah...</div>
                    @error('file_import') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mt-6 sm:flex sm:flex-row-reverse">
                    <button
                        @click="if (confirm('Anda yakin ingin mengimpor file ini? Data dengan Kode Klasifikasi yang sama akan diperbarui.')) { $wire.call('import') }"
                        type="button"
                        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto">
                        Proses Impor
                    </button>
                    <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>