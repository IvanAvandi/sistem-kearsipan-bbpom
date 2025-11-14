@if ($errors->any())
    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
        <strong>Whoops! Terjadi kesalahan.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-label for="kode_klasifikasi" :value="__('Kode Klasifikasi*')" />
            <x-input id="kode_klasifikasi" class="block mt-1 w-full" type="text" name="kode_klasifikasi" :value="old('kode_klasifikasi', $item->kode_klasifikasi ?? '')" required />
            @error('kode_klasifikasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <x-label for="nama_klasifikasi" :value="__('Nama Klasifikasi*')" />
            <x-input id="nama_klasifikasi" class="block mt-1 w-full" type="text" name="nama_klasifikasi" :value="old('nama_klasifikasi', $item->nama_klasifikasi ?? '')" required />
            @error('nama_klasifikasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <x-label for="masa_aktif" :value="__('Masa Aktif (Tahun)*')" />
            <x-input id="masa_aktif" class="block mt-1 w-full" type="number" name="masa_aktif" :value="old('masa_aktif', $item->masa_aktif ?? '')" required min="0" />
            @error('masa_aktif') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <x-label for="masa_inaktif" :value="__('Masa Inaktif (Tahun)*')" />
            <x-input id="masa_inaktif" class="block mt-1 w-full" type="number" name="masa_inaktif" :value="old('masa_inaktif', $item->masa_inaktif ?? '')" required min="0" />
            @error('masa_inaktif') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <x-label for="status_akhir" :value="__('Status Akhir*')" />
            <select name="status_akhir" id="status_akhir" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                <option value="Musnah" {{ old('status_akhir', $item->status_akhir ?? '') == 'Musnah' ? 'selected' : '' }}>Musnah</option>
                <option value="Permanen" {{ old('status_akhir', $item->status_akhir ?? '') == 'Permanen' ? 'selected' : '' }}>Permanen</option>
            </select>
            @error('status_akhir') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <x-label for="klasifikasi_keamanan" :value="__('Klasifikasi Keamanan*')" />
            <select name="klasifikasi_keamanan" id="klasifikasi_keamanan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                <option value="Biasa/Terbuka" {{ old('klasifikasi_keamanan', $item->klasifikasi_keamanan ?? 'Biasa/Terbuka') == 'Biasa/Terbuka' ? 'selected' : '' }}>Biasa/Terbuka</option>
                <option value="Terbatas" {{ old('klasifikasi_keamanan', $item->klasifikasi_keamanan ?? '') == 'Terbatas' ? 'selected' : '' }}>Terbatas</option>
                <option value="Rahasia" {{ old('klasifikasi_keamanan', $item->klasifikasi_keamanan ?? '') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                <option value="Sangat Rahasia" {{ old('klasifikasi_keamanan', $item->klasifikasi_keamanan ?? '') == 'Sangat Rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
            </select>
            @error('klasifikasi_keamanan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div> 
            <x-label for="hak_akses" :value="__('Hak Akses (Opsional)')" />
            <x-input id="hak_akses" class="block mt-1 w-full" type="text" name="hak_akses" :value="old('hak_akses', $item->hak_akses ?? '')" />
             @error('hak_akses') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
         <div>
            {{-- Tampilkan kolom unit_pengolah yang asli dari tabel --}}
            <x-label for="unit_pengolah" :value="__('Unit Pengolah (Opsional)')" />
            <x-input id="unit_pengolah" class="block mt-1 w-full" type="text" name="unit_pengolah" :value="old('unit_pengolah', $item->unit_pengolah ?? '')" />
            @error('unit_pengolah') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('admin.klasifikasi.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
        Batal
    </a>
    <x-button>
        {{ isset($item) ? 'Update Klasifikasi' : 'Simpan Klasifikasi' }} 
    </x-button>
</div>