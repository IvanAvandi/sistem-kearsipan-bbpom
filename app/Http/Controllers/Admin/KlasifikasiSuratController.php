<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiSurat;
use Illuminate\Http\Request;

class KlasifikasiSuratController extends Controller
{
    public function index()
    {
        $items = KlasifikasiSurat::orderBy('kode_klasifikasi', 'asc')->get();
        return view('admin.klasifikasi.index', compact('items'));
    }

    public function create()
    {
        return view('admin.klasifikasi.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:255|unique:klasifikasi_surat',
            'nama_klasifikasi' => 'required|string',
            'masa_aktif' => 'required|integer|min:0',
            'masa_inaktif' => 'required|integer|min:0',
            'status_akhir' => 'required|in:Musnah,Permanen',
            'klasifikasi_keamanan' => 'required|in:Biasa/Terbuka,Terbatas,Rahasia,Sangat Rahasia',
            'hak_akses' => 'nullable|string',
            'unit_pengolah' => 'nullable|string', 
        ]);

        $dataToCreate = $request->except(['_token', 'divisi_id']);

        KlasifikasiSurat::create($dataToCreate);

        return redirect()->route('admin.klasifikasi.index')->with('success', 'Data klasifikasi berhasil ditambahkan.');
    }

    public function show(KlasifikasiSurat $klasifikasi)
    {
        abort(404);
    }

    public function edit(KlasifikasiSurat $klasifikasi)
    {
        return view('admin.klasifikasi.edit', ['item' => $klasifikasi]); 
    }

    public function update(Request $request, KlasifikasiSurat $klasifikasi)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:255|unique:klasifikasi_surat,kode_klasifikasi,' . $klasifikasi->id,
            'nama_klasifikasi' => 'required|string',
            'masa_aktif' => 'required|integer|min:0',
            'masa_inaktif' => 'required|integer|min:0',
            'status_akhir' => 'required|in:Musnah,Permanen',
            'klasifikasi_keamanan' => 'required|in:Biasa/Terbuka,Terbatas,Rahasia,Sangat Rahasia', 
            'hak_akses' => 'nullable|string',
            'unit_pengolah' => 'nullable|string', 
        ]);

        $dataToUpdate = $request->except(['_token', '_method', 'divisi_id']);

        $klasifikasi->update($dataToUpdate);

        return redirect()->route('admin.klasifikasi.index')->with('success', 'Data klasifikasi berhasil diperbarui.');
    }

    public function destroy(KlasifikasiSurat $klasifikasi)
    {
        try {
            $klasifikasi->delete();
            return redirect()->route('admin.klasifikasi.index')->with('success', 'Data klasifikasi berhasil dihapus (soft delete).');
        } catch (\Exception $e) {
             return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}