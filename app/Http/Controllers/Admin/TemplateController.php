<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    // Method ini hanya untuk menampilkan view utama yang berisi komponen Livewire
    public function index()
    {
        return view('admin.templates.index');
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'file_template' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120', // maks 5MB
        ]);

        $file = $request->file('file_template');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('templates', $fileName, 'public');

        Template::create([
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'nama_file' => $fileName,
            'file_path' => $filePath,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Format berhasil ditambahkan.');
    }

    public function edit(Template $template)
    {
        return view('admin.templates.edit', ['item' => $template]);
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'file_template' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = $request->only(['nama_template', 'deskripsi', 'kategori']);

        if ($request->hasFile('file_template')) {
            // Hapus file lama
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }

            // Upload file baru
            $file = $request->file('file_template');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('templates', $fileName, 'public');

            $data['nama_file'] = $fileName;
            $data['file_path'] = $filePath;
        }

        $template->update($data);

        return redirect()->route('admin.templates.index')->with('success', 'Format berhasil diperbarui.');
    }
    
    // Method destroy tidak digunakan di sini karena sudah ditangani oleh Livewire
    public function destroy(Template $template)
    {
        // Dikosongkan
    }
}