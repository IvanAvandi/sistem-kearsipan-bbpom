<div>
    <x-label for="nama_bentuk_naskah" value="Nama Bentuk Naskah*" />
    <x-input id="nama_bentuk_naskah" class="block mt-1 w-full" type="text" name="nama_bentuk_naskah" :value="old('nama_bentuk_naskah', $item->nama_bentuk_naskah ?? '')" required autofocus />
</div>
<div class="flex items-center justify-end mt-4">
    <a href="{{ route('admin.bentuk-naskah.index') }}" class="text-gray-600 mr-4">Batal</a>
    <x-button>Simpan</x-button>
</div>