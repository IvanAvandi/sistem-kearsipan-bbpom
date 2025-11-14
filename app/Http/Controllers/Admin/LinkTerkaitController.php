<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkTerkait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkTerkaitController extends Controller
{
    // Method ini HANYA memuat view utama.
    // Semua logika tabel (search, delete, paginate) sudah diurus Livewire.
    public function index()
    {
        return view('admin.link-terkait.index');
    }

    public function create()
    {
        return view('admin.link-terkait.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link_url' => 'required|url',
            'lokasi' => 'required|string',
            'status' => 'required|in:Aktif,NonAktif',
            'path_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024' // Validasi ikon
        ]);

        $data = $request->except('path_icon');

        if ($request->hasFile('path_icon')) {
            $data['path_icon'] = $request->file('path_icon')->store('icons', 'public');
        }

        LinkTerkait::create($data);
        return redirect()->route('admin.link-terkait.index')->with('success', 'Link Terkait berhasil ditambahkan.');
    }

    public function edit(LinkTerkait $linkTerkait)
    {
        return view('admin.link-terkait.edit', ['item' => $linkTerkait]);
    }

    public function update(Request $request, LinkTerkait $linkTerkait)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link_url' => 'required|url',
            'lokasi' => 'required|string',
            'status' => 'required|in:Aktif,NonAktif',
            'path_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);
        
        $data = $request->except('path_icon');

        if ($request->hasFile('path_icon')) {
            // Hapus ikon lama jika ada
            if ($linkTerkait->path_icon && Storage::disk('public')->exists($linkTerkait->path_icon)) {
                Storage::disk('public')->delete($linkTerkait->path_icon);
            }
            $data['path_icon'] = $request->file('path_icon')->store('icons', 'public');
        }

        $linkTerkait->update($data);
        return redirect()->route('admin.link-terkait.index')->with('success', 'Link Terkait berhasil diperbarui.');
    }

    public function destroy(LinkTerkait $linkTerkait) { /* ... Logika dipindah ke Livewire ... */ }
}