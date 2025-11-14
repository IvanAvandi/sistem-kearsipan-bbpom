{{--
|--------------------------------------------------------------------------
| Halaman: Daftar Usulan Pemusnahan (index)
|--------------------------------------------------------------------------
|
| Halaman ini bertanggung jawab untuk menampilkan daftar semua usulan
| pemusnahan arsip. Ini adalah komponen Livewire.
|
| @var \Illuminate\Pagination\LengthAwarePaginator $usulans
|
--}}
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">

    {{-- ====================================================== --}}
    {{-- == JUDUL HALAMAN (PAGE HEADER)                      == --}}
    {{-- ====================================================== --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Usulan Pemusnahan</h2>
        <p class="mt-1 text-base text-gray-500">Pantau dan kelola semua usulan pemusnahan arsip dari draft hingga selesai.</p>
    </div>

    {{-- ====================================================== --}}
    {{-- == KONTROL FILTER DAN PENCARIAN                     == --}}
    {{-- ====================================================== --}}
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">

        {{-- Kontrol Sisi Kiri: Pencarian --}}
        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <x-input type="text" wire:model.debounce.300ms="search" placeholder="Cari nomor usulan/nama..." class="pl-10 w-full" />
            </div>
        </div>
        
        {{-- Kontrol Sisi Kanan: Filter Status --}}
        <div class="flex justify-end w-full sm:w-auto">
            <select wire:model="status" class="w-full sm:w-auto rounded-md shadow-sm border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Semua Status</option>
                <option value="Draft">Draft</option>
                <option value="Diajukan ke Pusat">Diajukan ke Pusat</option>
                <option value="Musnah, Menunggu BA">Menunggu Berita Acara</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- == NOTIFIKASI (SESSION MESSAGES)                    == --}}
    {{-- ====================================================== --}}
    @if (session()->has('success'))
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">{{ session('error') }}</div>
    @endif

    {{-- ====================================================== --}}
    {{-- == TABEL DATA USULAN                                == --}}
    {{-- ====================================================== --}}
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-16 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">No</th>
                    <th scope="col" class="w-1/3 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nomor Usulan</th>
                    <th scope="col" class="w-1/4 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Dibuat Oleh</th>
                    <th scope="col" class="w-1/4 px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Jumlah Arsip</th>
                    <th scope="col" class="w-40 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th scope="col" class="w-32 px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                
                {{-- Loop data usulan, @forelse menangani jika data kosong --}}
                @forelse ($usulans as $usulan)
                    <tr class="odd:bg-white even:bg-gray-50 align-middle">
                        
                        {{-- Kalkulasi nomor urut berdasarkan paginasi --}}
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + $usulans->firstItem() - 1 }}</td>
                        
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium whitespace-normal break-words" title="{{ $usulan->nomor_usulan }}">{{ $usulan->nomor_usulan }}</td>
                        
                        {{-- Mengambil nama dari relasi user, dengan null-safe operator --}}
                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $usulan->user->name ?? 'N/A' }}</td> 
                        
                        {{-- Format tanggal menggunakan Carbon (isoFormat) --}}
                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $usulan->created_at->isoFormat('D MMMM YYYY') }}</td>
                        
                        {{-- Menghitung jumlah arsip terkait via relasi --}}
                        <td class="px-4 py-3 text-sm text-gray-700 text-center whitespace-nowrap">{{ $usulan->arsips->count() }}</td>
                        
                        <td class="px-4 py-3 text-sm text-center whitespace-nowrap">
                            <span class="inline-flex justify-center items-center px-3 py-1 text-xs font-medium rounded-full w-36
                            @switch($usulan->status)
                                @case('Draft') bg-gray-200 text-gray-800 @break
                                @case('Diajukan ke Pusat') bg-blue-100 text-blue-800 @break
                                @case('Musnah, Menunggu BA') bg-yellow-100 text-yellow-800 @break
                                @case('Selesai') bg-green-100 text-green-800 @break
                                @case('Dibatalkan') bg-red-100 text-red-800 @break 
                                @case('Ditolak') bg-red-100 text-red-800 @break
                                @default bg-gray-200 text-gray-800 @break
                            @endswitch">
                                {{ $usulan->status }}
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <a href="{{ route('admin.usulan-pemusnahan.show', $usulan->id) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium
                                      bg-white text-gray-700 border border-gray-300 rounded-md shadow-sm
                                      hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                
                {{-- Tampilan jika tidak ada data usulan --}}
                @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Data usulan pemusnahan tidak ditemukan.</td></tr>
                @endforelse
                
            </tbody>
        </table>
    </div>

    {{-- ====================================================== --}}
    {{-- == PAGINASI                                         == --}}
    {{-- ====================================================== --}}
    <div class="mt-4">
        {{ $usulans->links() }}
    </div>

</div>