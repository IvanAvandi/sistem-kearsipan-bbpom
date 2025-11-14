<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BentukNaskah;
use Illuminate\Http\Request;

class BentukNaskahController extends Controller
{
    public function index()
    {
        return view('admin.bentuk-naskah.index');
    }

    public function create()
    {
        return view('admin.bentuk-naskah.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_bentuk_naskah' => 'required|string|max:255|unique:bentuk_naskahs']);
        BentukNaskah::create($request->all());
        return redirect()->route('admin.bentuk-naskah.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(BentukNaskah $bentukNaskah)
    {
        return view('admin.bentuk-naskah.edit', ['item' => $bentukNaskah]);
    }

    public function update(Request $request, BentukNaskah $bentukNaskah)
    {
        $request->validate(['nama_bentuk_naskah' => 'required|string|max:255|unique:bentuk_naskahs,nama_bentuk_naskah,' . $bentukNaskah->id]);
        $bentukNaskah->update($request->all());
        return redirect()->route('admin.bentuk-naskah.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(BentukNaskah $bentukNaskah)
    {
   
    }
}