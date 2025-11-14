<div>
    {{-- ====================================================== --}}
    {{-- == HEADER HALAMAN (BREADCRUMBS)                     == --}}
    {{-- ====================================================== --}}
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Usulan Pindah' => route('admin.usul-pindah-review.index'),
            'Detail Usulan' => '#'
            ]" icon="usulan_pindah" />
    </x-slot>

    {{-- ====================================================== --}}
    {{-- == MODAL: KEMBALIKAN USULAN (REVISI)                == --}}
    {{-- ====================================================== --}}
    <div x-data="{ show: @entangle('showKembalikanModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-kembalikan" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title-kembalikan">Kembalikan Usulan (Perlu Revisi)</h3>
                <p class="mt-2 text-sm text-gray-500">Tuliskan catatan revisi yang jelas agar Arsiparis dapat memperbaiki usulan ini.</p>
                
                <form wire:submit.prevent="kembalikan" class="mt-5 space-y-4">
                    <div>
                        <label for="catatan_admin_modal" class="block text-sm font-medium text-gray-700">Catatan Revisi*</label>
                        <textarea id="catatan_admin_modal" wire:model.defer="catatan_admin" rows="4" 
                                  class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('catatan_admin') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror" 
                                  placeholder="Contoh: File BA tidak ditandatangani, harap upload ulang..."></textarea>
                        @error('catatan_admin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto transition duration-150 ease-in-out">
                            <span wire:loading wire:target="kembalikan">Memproses...</span>
                            <span wire:loading.remove wire:target="kembalikan">Kembalikan ke Arsiparis</span>
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto transition duration-150 ease-in-out">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session()->has('error'))
                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-sm" role="alert">{{ session('error') }}</div>
            @endif
            
            {{-- ====================================================== --}}
            {{-- == KARTU 1: INFORMASI USULAN                        == --}}
            {{-- ====================================================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-start space-x-5">
                        @php
                            $iconClass = 'bg-gray-100 text-gray-600';
                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17" />';
                            if($usulan->status == 'Selesai') {
                                $iconClass = 'bg-green-100 text-green-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                            } elseif($usulan->status == 'Dikembalikan') {
                                $iconClass = 'bg-yellow-100 text-yellow-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
                            } elseif($usulan->status == 'Diajukan') {
                                $iconClass = 'bg-blue-100 text-blue-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />';
                            } elseif($usulan->status == 'Dibatalkan') {
                                $iconClass = 'bg-red-100 text-red-600';
                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                            }
                        @endphp
                        <div class="flex-shrink-0 {{ $iconClass }} p-3 rounded-lg">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $iconSvg !!}</svg>
                        </div> 
                        
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $usulan->nomor_ba }}</h2>
                            
                            @if($usulan->diusulkanOleh)
                                <p class="mt-1 text-base text-gray-500">
                                    Diusulkan oleh: <span class="font-medium text-gray-700">{{ $usulan->diusulkanOleh?->name ?? $usulan->user?->name ?? 'User Dihapus' }}</span>
                                    (Bidang {{ $usulan->user?->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A' }})
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Pada: <span class="font-medium text-gray-700">{{ $usulan->diajukan_pada->isoFormat('D MMM Y, HH:mm') }}</span>
                                </p>
                            @else
                                <p class="mt-1 text-base text-gray-500">
                                    Pembuat Draft: <span class="font-medium text-gray-700">{{ $usulan->user?->name ?? 'User Dihapus' }}</span>
                                    (Bidang {{ $usulan->user?->divisi ? ($usulan->user->divisi->nama === 'Informasi dan Komunikasi' ? 'Infokom' : $usulan->user->divisi->nama) : 'N/A' }})
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Dibuat pada: <span class="font-medium text-gray-700">{{ $usulan->created_at->isoFormat('D MMM Y, HH:mm') }}</span>
                                </p>
                            @endif

                            <div class="mt-4">
                                <span class="px-2.5 py-0.5 text-sm font-medium rounded-full
                                @switch($usulan->status)
                                    @case('Diajukan') bg-blue-100 text-blue-800 @break
                                    @case('Dikembalikan') bg-yellow-100 text-yellow-800 @break
                                    @case('Selesai') bg-green-100 text-green-800 @break
                                    @case('Dibatalkan') bg-red-100 text-red-800 @break
                                    @default bg-gray-200 text-gray-800 @break
                                @endswitch">
                                    Status: {{ $usulan->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- == KARTU 2: INFORMASI KONDISIONAL (PER STATUS)      == --}}
            {{-- ====================================================== --}}

            @if($usulan->status == 'Selesai')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-green-50 border-green-200 p-6 rounded-lg border shadow-sm h-full">
                        <h4 class="font-semibold text-green-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            Usulan Disetujui
                        </h4>
                        <p class="text-sm text-green-900">Arsip telah resmi diterima dan dipindahkan ke Unit Kearsipan Tata Usaha.</p>
                        @if($usulan->disetujuiOleh)
                        <p class="text-sm text-green-800 mt-2">
                            Disetujui oleh: <span class="font-medium">{{ $usulan->disetujuiOleh?->name ?? 'User Dihapus' }}</span>
                            ({{ $usulan->disetujui_pada->isoFormat('D MMM Y, HH:mm') }})
                        </p>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->nomor_ba ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        @if($usulan->file_ba_path)
                                        <a href="{{ Storage::url($usulan->file_ba_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                        @else
                                        <span class="text-gray-500 italic text-sm">(Dokumen BA tidak diupload)</span>
                                        @endif
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($usulan->status == 'Dikembalikan')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-yellow-50 border-yellow-200 p-6 rounded-lg border shadow-sm h-full">
                        <h4 class="font-semibold text-yellow-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-yellow-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                            Catatan Pengembalian
                        </h4>
                        @if($usulan->dikembalikanOleh)
                        <p class="text-sm text-yellow-800 mb-2">
                            Dikembalikan oleh: <span class="font-medium">{{ $usulan->dikembalikanOleh?->name ?? 'User Dihapus' }}</span>
                            ({{ $usulan->dikembalikan_pada->isoFormat('D MMM Y, HH:mm') }})
                        </p>
                        @endif
                        <p class="text-sm text-yellow-700 italic">"{{ $usulan->catatan_admin }}"</p>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->nomor_ba ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        @if($usulan->file_ba_path)
                                        <a href="{{ Storage::url($usulan->file_ba_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                        @else
                                        <span class="text-gray-500 italic text-sm">(Dokumen BA tidak diupload)</span>
                                        @endif
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($usulan->status == 'Dibatalkan')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-red-50 border-red-200 p-6 rounded-lg border shadow-sm h-full">
                        <h4 class="font-semibold text-red-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            Usulan Dibatalkan
                        </h4>
                        <p class="text-sm text-red-900">Usulan ini dibatalkan. Arsip dikembalikan ke status Inaktif.</p>
                        @if($usulan->dibatalkanOleh)
                        <p class="text-sm text-red-800 mt-2">
                            Dibatalkan oleh: <span class="font-medium">{{ $usulan->dibatalkanOleh?->name ?? 'User Dihapus' }}</span>
                            ({{ $usulan->dibatalkan_pada->isoFormat('D MMM Y, HH:mm') }})
                        </p>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->nomor_ba ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        @if($usulan->file_ba_path)
                                        <a href="{{ Storage::url($usulan->file_ba_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                        @else
                                        <span class="text-gray-500 italic text-sm">(Dokumen BA tidak diupload)</span>
                                        @endif
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ====================================================== --}}
            {{-- == KARTU 3: DAFTAR ARSIP DALAM USULAN               == --}}
            {{-- ====================================================== --}}
            @if(in_array($usulan->status, ['Diajukan', 'Dikembalikan', 'Selesai']))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        @if($usulan->status == 'Selesai')
                            Daftar Arsip yang Telah Diterima ({{ $usulan->arsips->count() }} arsip)
                        @else
                            Daftar Arsip yang Diusulkan ({{ $usulan->arsips->count() }} arsip)
                        @endif
                    </h3>
                    
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-28 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Nomor Berkas</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Kode Klasifikasi</th>
                                    <th scope="col" class="w-1/2 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Uraian Berkas</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Tanggal Arsip</th>
                                    <th scope="col" class="w-1/6 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="w-24 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($usulan->arsips as $arsip)
                                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                                        <td class="px-4 py-3 text-center text-sm font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $arsip->klasifikasiSurat->kode_klasifikasi ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $arsip->uraian_berkas }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->isoFormat('D MMM Y') }}</td>
                                        
                                        @php
                                            $displayStatus = $usulan->status === 'Selesai' ? $arsip->status : 'Diusulkan Pindah';
                                        @endphp
                                        
                                        <td class="px-4 py-3 text-sm text-center whitespace-nowrap">
                                            <span class="inline-flex justify-center items-center px-3 py-1 text-xs font-medium rounded-full w-36
                                            @switch($displayStatus)
                                                @case('Aktif') bg-blue-100 text-blue-800 @break
                                                @case('Inaktif') bg-yellow-100 text-yellow-800 @break
                                                @case('Siap Dimusnahkan') bg-red-100 text-red-800 @break
                                                @case('Diusulkan Pindah') bg-purple-100 text-purple-800 @break
                                                @case('Permanen') bg-gray-200 text-gray-800 @break
                                                @default bg-gray-200 text-gray-800 @break
                                            @endswitch">
                                                {{ $displayStatus }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('arsip.show', $arsip->id) }}" class="text-gray-400 hover:text-indigo-600 transition duration-150 ease-in-out" title="Lihat Detail Arsip">
                                                <svg class="w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.522 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                            Tidak ada arsip dalam usulan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- ====================================================== --}}
            {{-- == KARTU 4: AKSI TINJAUAN (KONDISIONAL)             == --}}
            {{-- ====================================================== --}}
            @if($usulan->status == 'Diajukan')
                <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                    
                    <div class="lg:col-span-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Berita Acara</h3>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <dl class="text-sm space-y-3">
                                        <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->nomor_ba ?? '-' }}</dd></div>
                                        <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal BA:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->tanggal_ba ? $usulan->tanggal_ba->isoFormat('D MMM Y') : '-' }}</dd></div>
                                        <div class="pt-3 border-t border-gray-200">
                                            @if($usulan->file_ba_path)
                                            <a href="{{ Storage::url($usulan->file_ba_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen BA &rarr;</a>
                                            @else
                                            <span class="text-red-500 italic text-sm">(Dokumen BA belum diupload)</span>
                                            @endif
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-4 space-y-6">
                        
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 text-green-600 p-3 rounded-full">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Setujui Usulan Ini?</h3>
                                        <p class="text-sm text-gray-500">Arsip akan dipindahkan ke Tata Usaha.</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button type="button" 
                                            onclick="konfirmasiSetujui()"
                                            wire:loading.attr="disabled"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 transition duration-150 ease-in-out">
                                        Setujui & Terima Arsip
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-yellow-100 text-yellow-600 p-3 rounded-full">
                                         <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Kembalikan untuk Revisi?</h3>
                                        <p class="text-sm text-gray-500">Usulan akan dikembalikan ke Arsiparis.</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button type="button" 
                                            wire:click="openKembalikanModal"
                                            wire:loading.attr="disabled"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-yellow-600 transition duration-150 ease-in-out">
                                        Beri Catatan Revisi
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- == SKRIP SWEETALERT (KONFIRMASI & FEEDBACK)         == --}}
    {{-- ====================================================== --}}
    @push('scripts')
    <script>
        function konfirmasiSetujui() {
            Swal.fire({
                title: 'Setujui Usulan?',
                text: "Anda yakin ingin menyetujui usulan ini? Arsip akan dipindahkan ke Tata Usaha.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a', // Hijau
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyetujui...',
                        text: 'Mohon tunggu...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => { Swal.showLoading() }
                    });
                    Livewire.emit('triggerSetujui');
                }
            });
        }
    
        window.addEventListener('swal:alert', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });
    </script>
    @endpush
</div>