<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    {{-- ====================================================== --}}
    {{-- == JUDUL HALAMAN (PAGE HEADER)                      == --}}
    {{-- ====================================================== --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Link Terkait</h2>
        <p class="mt-1 text-base text-gray-500">Kelola tautan pintas yang ditampilkan di portal.</p>
    </div>

    {{-- ====================================================== --}}
    {{-- == KONTROL PENCARIAN & AKSI                         == --}}
    {{-- ====================================================== --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div class="relative w-full sm:w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <x-input type="text" wire:model.debounce.300ms="search" placeholder="Cari nama atau URL..." class="pl-10 w-full" />
        </div>
        
        <div class="w-full sm:w-auto">
            <a href="{{ route('admin.link-terkait.create') }}" 
               class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700">
                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                Tambah Link Baru
            </a>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- == NOTIFIKASI (ALERT)                               == --}}
    {{-- ====================================================== --}}
    @if (session()->has('success'))
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- ====================================================== --}}
    {{-- == TABEL DATA LINK TERKAIT                          == --}}
    {{-- ====================================================== --}}
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider w-16">No.</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Ikon</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nama Link</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($items as $item)
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $loop->iteration + $items->firstItem() - 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($item->path_icon)
                                <img src="{{ Storage::url($item->path_icon) }}" alt="ikon" class="h-10 w-10 object-cover rounded-md">
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <a href="{{ $item->link_url }}" target="_blank" class="text-blue-500 hover:underline" title="{{ $item->link_url }}">
                                {{ Str::limit($item->link_url, 40) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <span class="inline-flex justify-center items-center px-2 py-0.5 text-xs leading-5 font-semibold rounded-full w-24 {{ $item->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                           <div class="flex justify-center items-center space-x-4">
                                <a href="{{ route('admin.link-terkait.edit', $item->id) }}" title="Edit" class="text-gray-500 hover:text-indigo-600">
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
</div>