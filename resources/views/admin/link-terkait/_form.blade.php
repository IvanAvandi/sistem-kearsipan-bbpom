@if ($errors->any())
    <div class="mb-4">
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <x-label for="nama" :value="__('Nama Link*')" />
        <x-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $item->nama ?? '')" required autofocus />
    </div>

    <div>
        <x-label for="link_url" :value="__('URL Tujuan*')" />
        <x-input id="link_url" class="block mt-1 w-full" type="url" name="link_url" :value="old('link_url', $item->link_url ?? '')" required placeholder="https://contoh.com" />
    </div>

    <div>
        <x-label for="lokasi" :value="__('Lokasi Portal')" />
        <x-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi', $item->lokasi ?? 'Portal Awal')" />
    </div>

    <div>
        <x-label for="status" :value="__('Status*')" />
        <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            <option value="Aktif" {{ old('status', $item->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="NonAktif" {{ old('status', $item->status ?? '') == 'NonAktif' ? 'selected' : '' }}>NonAktif</option>
        </select>
    </div>

    <div>
        <x-label for="path_icon" :value="__('Ikon (Opsional, maks 1MB)')" />
        @if(isset($item) && $item->path_icon)
            <img src="{{ Storage::url($item->path_icon) }}" alt="ikon" class="h-16 w-16 object-cover rounded-md my-2">
        @endif
        <input id="path_icon" 
            name="path_icon" 
            type="file" 
            accept=".png, .jpg, .jpeg, .svg"
            class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>
</div>

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('admin.link-terkait.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
        Batal
    </a>
    <x-button>
        {{ isset($item) ? 'Update' : 'Simpan' }}
    </x-button>
</div>