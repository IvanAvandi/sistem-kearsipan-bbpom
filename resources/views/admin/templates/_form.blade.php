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
        <x-label for="nama_template" value="Nama Template*" />
        <x-input id="nama_template" class="block mt-1 w-full" type="text" name="nama_template" :value="old('nama_template', $item->nama_template ?? '')" required autofocus />
    </div>

    <div>
        <x-label for="deskripsi" value="Deskripsi" />
        <textarea id="deskripsi" name="deskripsi" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
    </div>

    <div>
        <x-label for="kategori" value="Kategori*" />
        <x-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" :value="old('kategori', $item->kategori ?? '')" required placeholder="Contoh: Surat Internal" />
    </div>

    <div>
        <x-label for="file_template" value="File Template (DOCX, PDF)*" />
        
        @if(isset($item) && $item->file_path)
            <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $item->nama_file }}</p>
        @endif

        <input id="file_template" 
               name="file_template" 
               type="file" 
               accept=".docx, .pdf"
               class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
               {{ isset($item) ? '' : 'required' }} />
    </div>
</div>

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('admin.templates.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
        Batal
    </a>
    <x-button>
        {{ isset($item) ? 'Update' : 'Simpan' }}
    </x-button>
</div>