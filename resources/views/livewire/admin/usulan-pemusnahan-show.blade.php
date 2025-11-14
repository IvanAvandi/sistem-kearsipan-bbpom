<div>
    {{-- ====================================================== --}}
    {{-- == HEADER HALAMAN (BREADCRUMBS)                     == --}}
    {{-- ====================================================== --}}
    <x-slot name="header">
        <x-breadcrumbs :links="[
            'Usul Musnah' => route('admin.usulan-pemusnahan.index'),
            'Detail Usulan' => '#'
            ]" icon="musnah" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session()->has('success'))
                <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm" role="alert">{{ session('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-sm" role="alert">{{ session('error') }}</div>
            @endif
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            {{-- ====================================================== --}}
            {{-- == KARTU 1: INFORMASI USULAN                        == --}}
            {{-- ====================================================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-start space-x-4">
                        @php 
                            $statusIconClass = 'bg-gray-100 text-gray-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.79 4 4s-1.79 4-4 4c-1.742 0-3.223-.835-3.772-2H2" />'; 
                        @endphp
                        @if($usulan->status == 'Selesai')
                             @php $statusIconClass = 'bg-green-100 text-green-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'; @endphp
                        @elseif(in_array($usulan->status, ['Dibatalkan', 'Ditolak']))
                             @php $statusIconClass = 'bg-red-100 text-red-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'; @endphp
                        @elseif($usulan->status == 'Musnah, Menunggu BA')
                             @php $statusIconClass = 'bg-yellow-100 text-yellow-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'; @endphp
                         @elseif($usulan->status == 'Diajukan ke Pusat')
                             @php $statusIconClass = 'bg-blue-100 text-blue-600'; $statusIconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />'; @endphp
                        @endif
                        
                        <div class="flex-shrink-0 {{ $statusIconClass }} p-3 rounded-lg">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $statusIconSvg !!}</svg>
                        </div>
                        
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $usulan->nomor_usulan }}</h2>
                            <p class="mt-1 text-base text-gray-500">
                                Dibuat oleh <span class="font-medium text-gray-700">{{ $usulan->user?->name ?? 'User Dihapus' }}</span> 
                                pada {{ \Carbon\Carbon::parse($usulan->tanggal_usulan)->isoFormat('D MMMM YYYY') }}
                            </p>
                            <div class="mt-2">
                                <span class="px-2.5 py-0.5 text-sm font-medium rounded-full
                                @switch($usulan->status)
                                    @case('Draft') bg-gray-200 text-gray-800 @break
                                    @case('Diajukan ke Pusat') bg-blue-100 text-blue-800 @break
                                    @case('Musnah, Menunggu BA') bg-yellow-100 text-yellow-800 @break
                                    @case('Selesai') bg-green-100 text-green-800 @break
                                    @case('Dibatalkan') bg-red-100 text-red-800 @break
                                    @case('Ditolak') bg-red-100 text-red-800 @break
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

            @if($usulan->status == 'Draft')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="bg-gray-50 border-gray-200 p-4 rounded-lg border">
                            <h4 class="font-semibold text-blue-800 flex items-center mb-2">
                                <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                Langkah Pengajuan
                            </h4>
                            <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                                <li>Klik <strong>Cetak Daftar Arsip</strong> di bawah.</li>
                                <li>Buat Surat Usulan Pemusnahan, lampirkan daftar arsip.</li>
                                <li>Klik <strong>Lengkapi Surat Usulan</strong> untuk mengunggah Surat Usulan yang sudah ditandatangani (PDF).</li>
                                <li>Klik <strong>Ajukan ke Pusat</strong> untuk mengirim usulan.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            
            @elseif($usulan->status == 'Diajukan ke Pusat')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 border-blue-200 p-4 rounded-lg border">
                        <h4 class="font-semibold text-blue-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a6 6 0 00-6 6v3.586l-1.293 1.293a1 1 0 001.414 1.414L6 12.414V16a1 1 0 001 1h6a1 1 0 001-1v-3.586l1.293 1.293a1 1 0 001.414-1.414L14 11.586V8a6 6 0 00-6-6zm0 12a2 2 0 100-4 2 2 0 000 4z" /></svg>
                            Menunggu Persetujuan Pusat
                        </h4>
                        <p class="text-sm text-blue-900">Usulan sedang ditinjau oleh ANRI/Pusat.</p>
                    </div>
                    <div class="bg-gray-50 border-gray-200 p-4 rounded-lg border">
                        <h4 class="font-semibold text-gray-800 flex items-center mb-2">
                            <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            Langkah Selanjutnya (Admin)
                        </h4>
                        <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                            <li>Tunggu <strong>Surat (Fisik) Persetujuan / Penolakan</strong> dari Pusat.</li>
                            <li>Jika <strong>disetujui</strong>, klik tombol <strong>Laksanakan Pemusnahan</strong>.</li>
                            <li>Jika <strong>ditolak</strong>, klik tombol <strong>Catat Penolakan</strong>.</li>
                            <li>(Opsional) Jika batal internal, klik <strong>Batalkan Usulan</strong>.</li>
                        </ol>
                    </div>
                </div>

            @elseif($usulan->status == 'Musnah, Menunggu BA')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pemusnahan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Surat Persetujuan
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">{{ $usulan->nomor_surat_persetujuan ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_surat_persetujuan ? \Carbon\Carbon::parse($usulan->tanggal_surat_persetujuan)->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    @if($usulan->file_surat_persetujuan_path)
                                    <div class="pt-2 border-t"><a href="{{ Storage::url($usulan->file_surat_persetujuan_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                     @else
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    @endif
                                </dl>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    Pemusnahan Fisik
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Status:</dt> <dd class="text-gray-800 font-medium text-right">Telah Dilaksanakan</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_pemusnahan_fisik ? \Carbon\Carbon::parse($usulan->tanggal_pemusnahan_fisik)->isoFormat('D MMM Y') : '-' }}</dd></div>
                                </dl>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Berita Acara
                                </h4>
                                 <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">-</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">-</dd></div>
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Belum Diarsip)</span></div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($usulan->status == 'Selesai')
                <div class="bg-green-50 border-green-200 p-4 rounded-lg border shadow-sm">
                    <h4 class="font-semibold text-green-800 flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Usulan Telah Selesai
                    </h4>
                    <p class="text-sm text-green-900 ml-7">Proses pemusnahan ini telah selesai dan Berita Acara telah diarsipkan.</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen Bukti</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                            
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Surat Usulan (Awal)
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">{{ $usulan->nomor_surat_usulan ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_surat_usulan ? $usulan->tanggal_surat_usulan->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    @if($usulan->file_surat_usulan_path)
                                    <div class="pt-2 border-t"><a href="{{ Storage::url($usulan->file_surat_usulan_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                    @else
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    @endif
                                </dl>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Surat Persetujuan
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">{{ $usulan->nomor_surat_persetujuan ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_surat_persetujuan ? \Carbon\Carbon::parse($usulan->tanggal_surat_persetujuan)->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    @if($usulan->file_surat_persetujuan_path)
                                    <div class="pt-2 border-t"><a href="{{ Storage::url($usulan->file_surat_persetujuan_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                    @else
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    @endif
                                </dl>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    Pemusnahan Fisik
                                </h4>
                                <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Status:</dt> <dd class="text-gray-800 font-medium text-right">Telah Dilaksanakan</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_pemusnahan_fisik ? \Carbon\Carbon::parse($usulan->tanggal_pemusnahan_fisik)->isoFormat('D MMM Y') : '-' }}</dd></div>
                                </dl>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Berita Acara
                                </h4>
                                 <dl class="mt-3 text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">{{ $usulan->nomor_bapa_diterima ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_bapa_diterima ? \Carbon\Carbon::parse($usulan->tanggal_bapa_diterima)->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    @if($usulan->file_bapa_diterima_path)
                                    <div class="pt-2 border-t"><a href="{{ Storage::url($usulan->file_bapa_diterima_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Dokumen &rarr;</a></div>
                                    @else
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($usulan->status == 'Ditolak')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            Detail Penolakan dari Pusat
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" /></svg>
                                    Dokumen Penolakan
                                </h4>
                                <dl class="text-sm space-y-2">
                                    <div class="flex justify-between"><dt class="text-gray-500">Nomor:</dt> <dd class="text-gray-800 font-medium text-right">{{ $usulan->nomor_surat_penolakan ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Tanggal:</dt> <dd class="text-gray-800 text-right">{{ $usulan->tanggal_surat_penolakan ? \Carbon\Carbon::parse($usulan->tanggal_surat_penolakan)->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    @if($usulan->file_surat_penolakan_path)
                                    <div class="pt-2 border-t"><a href="{{ Storage::url($usulan->file_surat_penolakan_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">Lihat Bukti &rarr;</a></div>
                                    @else
                                    <div class="pt-2 border-t"><span class="text-gray-500 italic">(Dokumen tidak diupload)</span></div>
                                    @endif
                                </dl>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h4 class="font-semibold text-gray-700 flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                                    Catatan
                                </h4>
                                @if($usulan->catatan_penolakan)
                                    <p class="text-sm text-gray-800 italic">"{{ $usulan->catatan_penolakan }}"</p>
                                @else
                                    <p class="text-sm text-gray-500 italic">(Tidak ada catatan)</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($usulan->status == 'Dibatalkan')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Usulan Dibatalkan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Proses usulan ini telah dibatalkan. Semua arsip yang terhubung telah dikembalikan ke status "Siap Dimusnahkan".
                        </p>
                    </div>
                </div>
            @endif

            {{-- ====================================================== --}}
            {{-- == KARTU 3: DAFTAR ARSIP (KONDISIONAL)               == --}}
            {{-- ====================================================== --}}
            @if(!in_array($usulan->status, ['Dibatalkan', 'Ditolak', 'Selesai']))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Daftar Arsip dalam Usulan Ini ({{ $usulan->status == 'Draft' ? $this->arsipList->total() : $usulan->arsips->count() }} arsip)</h3>
                            
                            <div class="flex items-center space-x-2">
                                @if(count($selectedArsip) > 0 && $usulan->status == 'Draft')
                                    <button type="button" onclick="konfirmasiHapusArsip()" 
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-700 transition duration-150 ease-in-out">
                                        <span wire:loading wire:target="removeSelectedArsips">Menghapus...</span>
                                        <span wire:loading.remove wire:target="removeSelectedArsips">Hapus Arsip ({{ count($selectedArsip) }})</span>
                                    </button>
                                @endif
                                @if($usulan->status == 'Draft')
                                    <button type="button" wire:click="cetakExcel" 
                                            class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <svg class="h-5 w-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" /><path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" /></svg>
                                        Cetak Daftar
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if($usulan->status == 'Draft')
                                        <th class="w-12 px-4 py-3">
                                            <input type="checkbox" wire:model="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </th>
                                        @endif
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">Nomor Berkas</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase">Kode Klasifikasi</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase">Uraian Berkas</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">Tanggal Arsip</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">Status Arsip</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php 
                                        $arsipCollection = ($usulan->status == 'Draft') ? $arsipList : $usulan->arsips;
                                    @endphp
                                    @forelse ($arsipCollection as $arsip)
                                        <tr class="align-middle {{ in_array($arsip->id, $selectedArsip ?? []) ? 'bg-indigo-50' : 'odd:bg-white even:bg-gray-50' }}">
                                            @if($usulan->status == 'Draft')
                                            <td class="px-4 py-3">
                                                <input type="checkbox" wire:model="selectedArsip" value="{{ $arsip->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            @endif
                                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $usulan->status == 'Draft' ? $loop->iteration + $arsipList->firstItem() - 1 : $loop->iteration }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $arsip->klasifikasiSurat()->withTrashed()->first()?->kode_klasifikasi ?? '' }}</td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $arsip->uraian_berkas }}</td>
                                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->isoFormat('D MMMM Y') }}</td>
                                            <td class="px-4 py-3 text-sm text-center">
                                                <span class="inline-flex justify-center items-center px-3 py-1 text-xs font-medium rounded-full w-36
                                                @if($arsip->status == 'Siap Dimusnahkan') bg-red-100 text-red-800
                                                @elseif($arsip->status == 'Musnah') bg-gray-600 text-white
                                                @else bg-orange-100 text-orange-800
                                                @endif">
                                                    {{ $arsip->status }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 text-center align-top">
                                                <a href="{{ route('arsip.show', $arsip->id) }}" class="text-gray-500 hover:text-blue-700" title="Lihat Detail Arsip">
                                                    <svg class="w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.522 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $usulan->status == 'Draft' ? '8' : '7' }}" class="px-6 py-10 text-center text-sm text-gray-500">
                                                Tidak ada arsip dalam usulan ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($usulan->status == 'Draft' && $arsipList->hasPages())
                        <div class="mt-4">
                            {{ $arsipList->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ====================================================== --}}
            {{-- == KARTU 4: LAYOUT AKSI (REVISI FINAL)              == --}}
            {{-- ====================================================== --}}
            <div class="grid grid-cols-1 @if(!in_array($usulan->status, ['Ditolak', 'Dibatalkan', 'Selesai'])) lg:grid-cols-10 @endif gap-6">
                
                @if($usulan->status != 'Selesai')
                <div class="@if(in_array($usulan->status, ['Draft', 'Diajukan ke Pusat', 'Musnah, Menunggu BA'])) lg:col-span-7 @else lg:col-span-10 @endif">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Detail Surat Usulan</h3>
                                @if($usulan->status == 'Draft')
                                <button wire:click="openUploadSuratModal" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-yellow-600 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                    {{ $usulan->file_surat_usulan_path ? 'Edit Surat Usulan' : 'Lengkapi Surat Usulan' }}
                                </button>
                                @endif
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <dl class="text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Nomor Surat Usulan:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->nomor_surat_usulan ?? '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-sm text-gray-500">Tanggal Surat Usulan:</dt> <dd class="text-sm font-medium text-gray-900 text-right">{{ $usulan->tanggal_surat_usulan ? $usulan->tanggal_surat_usulan->isoFormat('D MMM Y') : '-' }}</dd></div>
                                    <div class="pt-3 border-t border-gray-200">
                                        @if($usulan->file_surat_usulan_path)
                                        <a href="{{ Storage::url($usulan->file_surat_usulan_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium text-sm transition duration-150 ease-in-out">Lihat Dokumen Surat Usulan &rarr;</a>
                                        @else
                                        <span class="text-red-500 italic text-sm">(Dokumen Surat Usulan belum diupload)</span>
                                        @endif
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
    
                @if(!in_array($usulan->status, ['Ditolak', 'Dibatalkan', 'Selesai']))
                <div class="lg:col-span-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Usulan</h3>
                            @if($usulan->status == 'Draft')
                            <div class="space-y-3">
                                <button type="button" onclick="konfirmasiAjukan()"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                        class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition duration-150 ease-in-out">
                                    <span wire:loading wire:target="ajukan">Mengajukan...</span>
                                    <span wire:loading.remove wire:target="ajukan">Ajukan ke Pusat</span>
                                </button>
                                <button type="button" onclick="konfirmasiHapusDraft()"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                        class="inline-flex items-center justify-center w-full px-4 py-2 text-red-600 border border-red-600 rounded-md font-semibold text-sm hover:bg-red-50 transition duration-150 ease-in-out">
                                    <span wire:loading wire:target="hapusDraft">Menghapus...</span>
                                    <span wire:loading.remove wire:target="hapusDraft">Hapus Draft</span>
                                </button>
                            </div>
                            @elseif($usulan->status == 'Diajukan ke Pusat')
                            <div class="flex flex-col gap-2">
                                <button wire:click.prevent="openLaksanakanModal" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700">Laksanakan Pemusnahan</button>
                                <button wire:click.prevent="openTolakModal" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-yellow-600">Catat Penolakan</button>
                                <button type="button" onclick="konfirmasiBatalkan()" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-700">Batalkan Usulan</button>
                            </div>
                            @elseif($usulan->status == 'Musnah, Menunggu BA')
                            <div class="flex flex-col gap-2">
                                <h4 class="text-sm text-gray-600">Langkah selanjutnya adalah mengunggah Berita Acara final dari Pusat untuk menyelesaikan proses.</h4>
                                <button wire:click.prevent="openArsipkanBapaModal" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700">Arsipkan Berita Acara</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>
    
    {{-- ====================================================== --}}
    {{-- == SEMUA MODAL POP-UP                               == --}}
    {{-- ====================================================== --}}

    {{-- MODAL 1: LAKSANAKAN PEMUSNAHAN --}}
    <div x-data="{ show: @entangle('showLaksanakanModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Pencatatan Pelaksanaan Pemusnahan</h3>
                <p class="mt-2 text-sm text-gray-500">Lengkapi data Surat Persetujuan dari Pusat dan tanggal pemusnahan fisik.</p>
                <form wire:submit.prevent="laksanakanPemusnahan" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_surat_persetujuan" class="block text-sm font-medium text-gray-700">Nomor Surat Persetujuan*</label>
                        <input type="text" wire:model.defer="nomor_surat_persetujuan" id="nomor_surat_persetujuan" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('nomor_surat_persetujuan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('nomor_surat_persetujuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_surat_persetujuan" class="block text-sm font-medium text-gray-700">Tanggal Surat Persetujuan*</label>
                        <input type="date" wire:model.defer="tanggal_surat_persetujuan" id="tanggal_surat_persetujuan" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('tanggal_surat_persetujuan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('tanggal_surat_persetujuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_pemusnahan_fisik" class="block text-sm font-medium text-gray-700">Tanggal Pemusnahan Fisik*</label>
                        <input type="date" wire:model.defer="tanggal_pemusnahan_fisik" id="tanggal_pemusnahan_fisik" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('tanggal_pemusnahan_fisik') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('tanggal_pemusnahan_fisik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="file_surat_persetujuan" class="block text-sm font-medium text-gray-700">Upload Scan Surat Persetujuan (PDF)</label>
                        <input type="file" wire:model="file_surat_persetujuan" id="file_surat_persetujuan" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="file_surat_persetujuan">Mengunggah...</div>
                        @error('file_surat_persetujuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto">
                            Simpan & Konfirmasi
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- MODAL 2: ARSIPKAN BAPA --}}
    <div x-data="{ show: @entangle('showArsipkanBapaModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-bapa" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-bapa">Arsipkan Berita Acara</h3>
                <p class="mt-2 text-sm text-gray-500">Unggah Berita Acara yang diterima dari Pusat untuk menutup proses.</p>
                <form wire:submit.prevent="arsipkanBapaFinal" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_bapa_diterima" class="block text-sm font-medium text-gray-700">Nomor Berita Acara*</label>
                        <input type="text" wire:model.defer="nomor_bapa_diterima" id="nomor_bapa_diterima" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('nomor_bapa_diterima') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('nomor_bapa_diterima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_bapa_diterima" class="block text-sm font-medium text-gray-700">Tanggal Berita Acara*</label>
                        <input type="date" wire:model.defer="tanggal_bapa_diterima" id="tanggal_bapa_diterima" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('tanggal_bapa_diterima') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('tanggal_bapa_diterima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="file_bapa_diterima" class="block text-sm font-medium text-gray-700">Upload Scan Berita Acara (PDF)</label>
                        <input type="file" wire:model="file_bapa_diterima" id="file_bapa_diterima" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="file_bapa_diterima">Mengunggah...</div>
                        @error('file_bapa_diterima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto">
                            Simpan & Selesaikan
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL 3: CATAT PENOLAKAN --}}
    <div x-data="{ show: @entangle('showTolakModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Catat Penolakan Usulan</h3>
                <p class="mt-2 text-sm text-gray-500">Lengkapi data surat penolakan resmi dari Pusat.</p>
                <form wire:submit.prevent="tolakUsulan" class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_surat_penolakan" class="block text-sm font-medium text-gray-700">Nomor Surat Penolakan*</label>
                        <input type="text" wire:model.defer="nomor_surat_penolakan" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('nomor_surat_penolakan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('nomor_surat_penolakan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_surat_penolakan" class="block text-sm font-medium text-gray-700">Tanggal Surat Penolakan*</label>
                        <input type="date" wire:model.defer="tanggal_surat_penolakan" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('tanggal_surat_penolakan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('tanggal_surat_penolakan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="file_surat_penolakan" class="block text-sm font-medium text-gray-700">Upload Scan Surat Penolakan (PDF)</label>
                        <input type="file" wire:model="file_surat_penolakan" id="file_surat_penolakan" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="file_surat_penolakan">Mengunggah...</div>
                        @error('file_surat_penolakan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="catatan_penolakan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea wire:model.defer="catatan_penolakan" rows="3" 
                                  class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('catatan_penolakan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"></textarea>
                    </div>
                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto">
                            Simpan Penolakan
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- MODAL 4: UPLOAD SURAT USULAN --}}
    <div x-data="{ show: @entangle('showUploadSuratModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-surat" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title-surat">
                    Lengkapi Surat Usulan
                </h3>
                <p class="mt-2 text-sm text-gray-500">Lengkapi detail Surat Usulan Pemusnahan untuk diajukan ke Pusat.</p>
                <form wire:submit.prevent="updateSuratUsulan" class="mt-5 space-y-4">
                    <div>
                        <label for="nomor_surat_usulan_modal" class="block text-sm font-medium text-gray-700">Nomor Surat Usulan*</label>
                        <input type="text" wire:model.defer="nomor_surat_usulan" id="nomor_surat_usulan_modal" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('nomor_surat_usulan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('nomor_surat_usulan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_surat_usulan_modal" class="block text-sm font-medium text-gray-700">Tanggal Surat Usulan*</label>
                        <input type="date" wire:model.defer="tanggal_surat_usulan" id="tanggal_surat_usulan_modal" 
                               class="block w-full mt-1 rounded-md shadow-sm sm:text-sm @error('tanggal_surat_usulan') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        @error('tanggal_surat_usulan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="file_surat_usulan_modal" class="block text-sm font-medium text-gray-700">
                            Upload Scan Surat Usulan (PDF)*
                            @if ($usulan->file_surat_usulan_path && !$file_surat_usulan)
                                <a href="{{ Storage::url($usulan->file_surat_usulan_path) }}" target="_blank" class="ml-2 text-xs text-blue-500 hover:underline">(Lihat file terupload)</a>
                            @endif
                        </label>
                        <input type="file" wire:model="file_surat_usulan" id="file_surat_usulan_modal" accept=".pdf" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition duration-150 ease-in-out">
                        <div wire:loading wire:target="file_surat_usulan" class="text-sm text-gray-500 mt-1">Mengunggah...</div>
                        @error('file_surat_usulan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-200 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-wait"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition duration-150 ease-in-out">
                            <span wire:loading wire:target="updateSuratUsulan">Menyimpan...</span>
                            <span wire:loading.remove wire:target="updateSuratUsulan">Simpan</span>
                        </button>
                        <button @click="show = false" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto transition duration-150 ease-in-out">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- ====================================================== --}}
    {{-- == SKRIP SWEETALERT (KONFIRMASI & FEEDBACK)         == --}}
    {{-- ====================================================== --}}
    @push('scripts')
    <script>
        function konfirmasiAjukan() {
            Swal.fire({
                title: 'Ajukan Usulan?',
                text: "Pastikan Surat Usulan sudah di-upload. Usulan akan diajukan ke Pusat untuk ditinjau.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#16a34a', // Hijau
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengajukan...',
                        text: 'Mohon tunggu...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => { Swal.showLoading() }
                    });
                    Livewire.emit('triggerAjukan');
                }
            });
        }
    
        function konfirmasiHapusDraft() {
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Draft usulan ini akan dihapus permanen dan semua arsip di dalamnya akan dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Draft!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => { Swal.showLoading() }
                    });
                    Livewire.emit('triggerHapusDraft');
                }
            });
        }
    
        function konfirmasiBatalkan() {
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Usulan ini akan dibatalkan dan semua arsip dikembalikan ke status 'Siap Dimusnahkan'.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Batalkan Usulan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                     Swal.fire({
                        title: 'Membatalkan...',
                        text: 'Mohon tunggu...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => { Swal.showLoading() }
                    });
                    Livewire.emit('triggerBatalkan');
                }
            });
        }
        
        function konfirmasiHapusArsip() {
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Arsip yang dipilih akan dihapus permanen dari usulan ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Arsip!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => { Swal.showLoading() }
                    });
                    Livewire.emit('triggerRemoveSelectedArsips');
                }
            });
        }

        // --- SCRIPT FEEDBACK SERVER ---
        window.addEventListener('swal:alert', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });

        window.addEventListener('swal:redirect', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.detail.message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = event.detail.url;
            });
        });
    </script>
    @endpush
</div>