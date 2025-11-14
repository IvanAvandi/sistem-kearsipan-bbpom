<x-app-layout>
    {{-- ====================================================== --}}
    {{-- == HEADER HALAMAN (BREADCRUMBS)                     == --}}
    {{-- ====================================================== --}}
    <x-slot name="header">
        <x-breadcrumbs :links="['Daftar Arsip' => route('arsip.index'), 'Detail Arsip' => '#']" />
    </x-slot>

    <div class="space-y-6">
        
        {{-- ====================================================== --}}
        {{-- == BLOK NOTIFIKASI KONTEKSTUAL (MUSNAH/PINDAH)        == --}}
        {{-- ====================================================== --}}
        @if(in_array($arsip->status, ['Musnah', 'Diusulkan Musnah']) && $arsip->usulanPemusnahan->isNotEmpty())
            @php
                $usulan = $arsip->usulanPemusnahan->first();
                $isMusnah = $arsip->status == 'Musnah';
                $alertBgClass = $isMusnah ? 'bg-gray-50' : 'bg-orange-50';
                $alertBorderClass = $isMusnah ? 'border-gray-400' : 'border-orange-400';
                $alertTextClass = $isMusnah ? 'text-gray-800' : 'text-orange-800';
                $alertIconClass = $isMusnah ? 'text-gray-500' : 'text-orange-500';
                $alertTitle = $isMusnah ? 'Arsip Telah Dimusnahkan' : 'Arsip Diusulkan Musnah';
                
                $alertMessage = $isMusnah ? 'Arsip ini telah resmi dimusnahkan.' : 'Arsip ini sedang dalam proses usulan pemusnahan.';
            @endphp
            <div class="{{ $alertBgClass }} border-l-4 {{ $alertBorderClass }} {{ $alertTextClass }} p-4 shadow-sm sm:rounded-lg" role="alert">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 {{ $alertIconClass }}">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    </div>
                    <div>
                        <p class="font-bold">{{ $alertTitle }}</p>
                        <p class="text-sm mt-1">{{ $alertMessage }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- ====================================================== --}}
            {{-- == KOLOM KIRI (INFORMASI BERKAS)                    == --}}
            {{-- ====================================================== --}}
            <div class="lg:w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center space-x-3">
                    <div class="text-blue-600"><svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Berkas</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Uraian Berkas</dt><dd class="mt-1 text-base text-gray-900 font-semibold">{{ $arsip->uraian_berkas }}</dd></div>
                        
                        <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Tanggal Arsip Perhitungan JRA</dt><dd class="mt-1 text-base text-gray-900">{{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->isoFormat('D MMMM YYYY') }}</dd></div>
                        
                        <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Bentuk Naskah</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->bentukNaskah?->nama_bentuk_naskah ?? '-' }}</dd></div>
                        <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Kurun Waktu</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->kurun_waktu ?? '-' }}</dd></div>
                        <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Jumlah</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->jumlah_berkas ?? '-' }}</dd></div>
                        <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Tingkat Perkembangan</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->tingkat_perkembangan }}</dd></div>
                        <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Lokasi Penyimpanan</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->lokasi_penyimpanan ?? '-' }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Keterangan Fisik</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->keterangan_fisik ?? '-' }}</dd></div>
                        
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Lampiran Berkas</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                @if($arsip->link_eksternal)
                                    <a href="{{ $arsip->link_eksternal }}" target="_blank" class="text-blue-600 hover:underline flex items-center space-x-1.5">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.225-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.665l3-3z" /><path d="M8.603 17.397a2.5 2.5 0 01-3.535-3.536l1.225-1.224a.75.75 0 00-1.06-1.06l-1.225 1.224a4 4 0 005.656 5.656l3-3a4 4 0 00-.225-5.865.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.665l-3 3z" /></svg>
                                        <span>{{ Str::limit($arsip->link_eksternal, 60) }}</span>
                                    </a>
                                @elseif($arsip->files->isNotEmpty())
                                    <ul class="space-y-2">
                                        @foreach($arsip->files as $file)
                                        <li>
                                            <a href="{{ Storage::url($file->path_file) }}" target="_blank" class="text-blue-600 hover:underline flex items-center space-x-1.5">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                                                <span>{{ $file->nama_file_original }} ({{ number_format($file->size / 1024 / 1024, 2) }} MB)</span>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                @else
                                    - (Tidak ada lampiran)
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- == KOLOM KANAN (KLASIFIKASI & RETENSI)              == --}}
            {{-- ====================================================== --}}
            <div class="lg:w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center space-x-3">
                     <div class="text-yellow-600"><svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v-3c0-1.1.9-2 2-2z" /></svg></div>
                    <h3 class="text-lg font-semibold text-gray-800">Klasifikasi & Retensi</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div><dt class="text-sm font-medium text-gray-500">Kode Klasifikasi</dt><dd class="mt-1 text-base text-gray-900 font-semibold">{{ $arsip->klasifikasiSurat?->kode_klasifikasi }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Nama Klasifikasi</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->klasifikasiSurat?->nama_klasifikasi }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Bidang</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->divisi?->nama ?? '-' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Jadwal Retensi</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->klasifikasiSurat?->masa_aktif }} thn Aktif, {{ $arsip->klasifikasiSurat?->masa_inaktif }} thn Inaktif</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Status Akhir</dt><dd class="mt-1 text-base font-bold text-gray-900">{{ $arsip->klasifikasiSurat?->status_akhir }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Keamanan</dt><dd class="mt-1 text-base text-gray-900">{{ $arsip->klasifikasiSurat?->klasifikasi_keamanan }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Status Saat Ini</dt><dd class="mt-1">
                            <span class="px-2.5 py-0.5 text-sm font-semibold rounded-full 
                            @switch($arsip->status) 
                                @case('Aktif') bg-blue-100 text-blue-800 @break 
                                @case('Inaktif') bg-yellow-100 text-yellow-800 @break 
                                @case('Siap Dimusnahkan') bg-red-100 text-red-800 @break 
                                @case('Diusulkan Musnah') bg-orange-100 text-orange-800 @break 
                                @case('Diusulkan Pindah') bg-purple-100 text-purple-800 @break
                                @case('Permanen') bg-gray-200 text-gray-800 @break 
                                @case('Musnah') bg-gray-600 text-white @break 
                            @endswitch">{{ $arsip->status }}</span></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- ====================================================== --}}
            {{-- == KOLOM KIRI (URAIAN ISI)                          == --}}
            {{-- ====================================================== --}}
            <div class="lg:w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center space-x-3">
                    <div class="text-green-600"><svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg></div>
                    <h3 class="text-lg font-semibold text-gray-800">Uraian Isi Informasi</h3>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">No.</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase">Uraian</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($arsip->uraianIsiInformasi as $uraian)
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $uraian->nomor_item ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $uraian->uraian }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $uraian->tanggal ? \Carbon\Carbon::parse($uraian->tanggal)->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $uraian->jumlah_lembar }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada daftar isi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- == KOLOM KANAN (TIMELINE RETENSI)                   == --}}
            {{-- ====================================================== --}}
            <div class="lg:w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center space-x-3">
                     <div class="text-red-600"><svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <h3 class="text-lg font-semibold text-gray-800">Timeline Retensi</h3>
                </div>
                <div class="p-6">
                    <ol class="relative border-l border-gray-200 ml-1">      
                        <li class="mb-10 ml-4">
                            <div class="absolute w-3 h-3 bg-green-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-500">{{ $arsip->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</time>
                            <h3 class="text-base font-semibold text-gray-900">Arsip Dibuat (Aktif)</h3>
                            <p class="text-sm font-normal text-gray-600">Dibuat oleh {{ $arsip->createdBy?->name ?? 'User Dihapus' }}.</p>
                        </li>
                        <li class="mb-10 ml-4">
                            @if($arsip->status != 'Aktif')
                                <div class="absolute w-3 h-3 bg-green-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <h3 class="text-base font-semibold text-gray-900">Menjadi Inaktif (Tercapai)</h3>
                            @else
                                <div class="absolute w-3 h-3 bg-yellow-400 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <h3 class="text-base font-semibold text-gray-900">Estimasi Inaktif</h3>
                            @endif
                            <time class="mb-1 text-sm font-normal leading-none text-gray-500">Estimasi: {{ $tanggal_inaktif->isoFormat('D MMMM YYYY') }}</time>
                            <p class="text-sm font-normal text-gray-600">Setelah masa retensi aktif ({{ $arsip->klasifikasiSurat?->masa_aktif }} tahun) berakhir.</p>
                        </li>
                        <li class="ml-4">
                            @if($arsip->status == 'Musnah' && $arsip->usulanPemusnahan->isNotEmpty())
                                @php $usulan = $arsip->usulanPemusnahan->first(); @endphp
                                <div class="absolute w-3 h-3 bg-green-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <h3 class="text-base font-semibold text-gray-900">Final: Dimusnahkan (Tercapai)</h3>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-500">Tanggal Pemusnahan Fisik: {{ $usulan->tanggal_pemusnahan_fisik ? \Carbon\Carbon::parse($usulan->tanggal_pemusnahan_fisik)->isoFormat('D MMMM YYYY') : 'N/A' }}</time>
                                <p class="text-sm font-normal text-gray-600">Berdasarkan Usulan No: {{ $usulan->nomor_usulan }}</p>
                            @elseif($arsip->status == 'Permanen')
                                <div class="absolute w-3 h-3 bg-green-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <h3 class="text-base font-semibold text-gray-900">Final: Permanen (Tercapai)</h3>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-500">Estimasi: {{ $tanggal_musnah_permanen->isoFormat('D MMMM YYYY') }}</col>
                            @else
                                <div class="absolute w-3 h-3 bg-red-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <h3 class="text-base font-semibold text-gray-900">Estimasi Final: {{ $arsip->klasifikasiSurat?->status_akhir }}</h3>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-500">Estimasi: {{ $tanggal_musnah_permanen->isoFormat('D MMMM YYYY') }}</col>
                                <p class="text-sm font-normal text-gray-600">Setelah masa retensi inaktif ({{ $arsip->klasifikasiSurat?->masa_inaktif }} tahun) berakhir.</p>
                            @endif
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>