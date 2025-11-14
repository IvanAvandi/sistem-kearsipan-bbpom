<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\BentukNaskah;
use App\Models\KlasifikasiSurat;
use App\Models\UraianIsiInformasi;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Scopes\DivisiScope;

class ArsipController extends Controller
{
    /**
     * Menampilkan halaman daftar arsip (Livewire).
     */
    public function index()
    {
        return view('arsip.index');
    }

    /**
     * Menampilkan form untuk membuat arsip baru.
     */
    public function create()
    {
        $data = $this->getFormDropdownData();
        return view('arsip.create', $data);
    }

    /**
     * Menyimpan arsip baru ke database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $divisiId = ($user->role === 'Admin') ? $request->input('divisi_id') : $user->divisi_id;
        
        $request->validate([
            'klasifikasi_surat_id' => 'required|exists:klasifikasi_surat,id',
            'divisi_id' => 'required|exists:divisi,id',
            'uraian_berkas' => 'required|string',
            'tanggal_arsip' => 'required|date',
            'uraian_isi' => 'required|array|min:1',
            'uraian_isi.*.uraian' => 'required|string',
            'uraian_isi.*.jumlah_lembar' => 'required|string',
            'upload_type' => 'nullable|in:file,link',
            'link_eksternal' => 'nullable|required_if:upload_type,link|url|max:2048',
            'files' => 'nullable|required_if:upload_type,file|array|max:5',
            'files.*' => 'file|mimes:pdf|max:2048', 
        ], [
            'files.max' => 'Anda hanya boleh mengupload maksimal 5 file.',
            'link_eksternal.required_if' => 'Link Eksternal wajib diisi jika Anda memilih opsi Link.',
        ]);
        
        if(!$divisiId) {
            return back()->with('error', 'Unit Pengolah tidak bisa ditentukan.')->withInput();
        }

        DB::beginTransaction();
        try {
            $arsip = Arsip::create([
                'divisi_id' => $divisiId,
                'klasifikasi_surat_id' => $request->klasifikasi_surat_id,
                'bentuk_naskah_id' => $request->bentuk_naskah_id,
                'kurun_waktu' => $request->kurun_waktu,
                'uraian_berkas' => $request->uraian_berkas,
                'tanggal_arsip' => $request->tanggal_arsip,
                'jumlah_berkas' => $request->jumlah_berkas,
                'tingkat_perkembangan' => $request->tingkat_perkembangan,
                'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
                'keterangan_fisik' => $request->keterangan_fisik,
                'status' => 'Aktif',
                'created_by' => $user->id,
                'link_eksternal' => $request->input('upload_type') === 'link' ? $request->input('link_eksternal') : null,
            ]);
            
            if ($request->input('upload_type') === 'file' && $request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('arsip_files', $fileName, 'public');
                    $fileSize = $file->getSize();

                    $arsip->files()->create([
                        'path_file' => $filePath,
                        'nama_file_original' => $file->getClientOriginalName(),
                        'size' => $fileSize,
                    ]);
                }
            }
            
            foreach ($request->uraian_isi as $uraian) {
                UraianIsiInformasi::create([
                    'arsip_id' => $arsip->id,
                    'nomor_item' => $uraian['nomor_item'],
                    'uraian' => $uraian['uraian'],
                    'tanggal' => $uraian['tanggal'],
                    'jumlah_lembar' => $uraian['jumlah_lembar'],
                ]);
            }

            DB::commit();
            return redirect()->route('arsip.index')->with('success', 'Arsip berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail arsip.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Memuat arsip tanpa scope global divisi
        $arsip = Arsip::withoutGlobalScope(DivisiScope::class)
                 ->with(['createdBy.divisi', 'divisi']) 
                 ->findOrFail($id);

        // Pengecekan hak akses: Admin atau pemilik arsip
        $isOwner = ($arsip->divisi_id == $user->divisi_id);
        if ($user->role !== 'Admin' && !$isOwner) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat arsip ini.');
        }

        $arsip->load([
            'klasifikasiSurat',
            'uraianIsiInformasi',
            'bentukNaskah',
            'usulanPemusnahan' => function ($query) {
                $query->with('user');
            },
            'files'
        ]);

        $tanggal_inaktif = null;
        $tanggal_musnah_permanen = null;

        if ($arsip->klasifikasiSurat) {
             $tanggal_inaktif = Carbon::parse($arsip->tanggal_arsip)->addYears($arsip->klasifikasiSurat->masa_aktif);
             $tanggal_musnah_permanen = $tanggal_inaktif->copy()->addYears($arsip->klasifikasiSurat->masa_inaktif);
        }

        return view('arsip.show', compact('arsip', 'tanggal_inaktif', 'tanggal_musnah_permanen'));
    }

    /**
     * Menampilkan form untuk mengedit arsip.
     */
    public function edit(Arsip $arsip)
    {
        $arsip->load('uraianIsiInformasi', 'files');
        $data = $this->getFormDropdownData();
        $data['arsip'] = $arsip;

        return view('arsip.edit', $data);
    }

    /**
     * Memperbarui arsip di database.
     */
    public function update(Request $request, Arsip $arsip)
    {
        $user = Auth::user();
        $divisiId = ($user->role === 'Admin') ? $request->input('divisi_id') : $user->divisi_id;
        
        $request->validate([
            'klasifikasi_surat_id' => 'required|exists:klasifikasi_surat,id',
            'divisi_id' => 'required|exists:divisi,id',
            'uraian_berkas' => 'required|string',
            'tanggal_arsip' => 'required|date',
            'uraian_isi' => 'required|array|min:1',
            'uraian_isi.*.uraian' => 'required|string',
            'uraian_isi.*.jumlah_lembar' => 'required|string',
            'upload_type' => 'nullable|in:file,link',
            'link_eksternal' => 'nullable|required_if:upload_type,link|url|max:2048',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:pdf|max:2048',
            'delete_files' => 'nullable|array',
            'delete_files.*' => 'integer|exists:arsip_files,id'
        ], [
            'files.max' => 'Anda hanya boleh mengupload maksimal 5 file.',
            'link_eksternal.required_if' => 'Link Eksternal wajib diisi jika Anda memilih opsi Link.',
        ]);

        if(!$divisiId) {
            return back()->with('error', 'Unit Pengolah tidak bisa ditentukan.')->withInput();
        }

        DB::beginTransaction();
        try {
            
            if ($request->has('delete_files')) {
                $filesToDelete = $arsip->files()->whereIn('id', $request->input('delete_files'))->get();
                
                foreach ($filesToDelete as $file) {
                    if ($file->path_file && Storage::disk('public')->exists($file->path_file)) {
                        Storage::disk('public')->delete($file->path_file);
                    }
                    $file->delete();
                }
            }

            $updateData = $request->except(['_token', '_method', 'files', 'uraian_isi', 'upload_type', 'link_eksternal', 'delete_files', 'nomor_berkas']);
            $updateData['divisi_id'] = $divisiId;
            
            if ($request->filled('upload_type')) {
                $updateData['link_eksternal'] = $request->input('upload_type') === 'link' ? $request->input('link_eksternal') : null;
            }
            
            $arsip->update($updateData);
            
            if ($request->input('upload_type') === 'file' && $request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('arsip_files', $fileName, 'public');
                    $fileSize = $file->getSize();

                    $arsip->files()->create([
                        'path_file' => $filePath,
                        'nama_file_original' => $file->getClientOriginalName(),
                        'size' => $fileSize,
                    ]);
                }
            }

            $arsip->uraianIsiInformasi()->delete();
            foreach ($request->uraian_isi as $uraian) {
                UraianIsiInformasi::create([
                    'arsip_id' => $arsip->id,
                    'nomor_item' => $uraian['nomor_item'],
                    'uraian' => $uraian['uraian'],
                    'tanggal' => $uraian['tanggal'],
                    'jumlah_lembar' => $uraian['jumlah_lembar'],
                ]);
            }

            DB::commit();
            return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus arsip dari database.
     */
    public function destroy(Arsip $arsip)
    {
        DB::beginTransaction();
        try {
            $arsip->load('files');

            foreach ($arsip->files as $file) {
                if ($file->path_file && Storage::disk('public')->exists($file->path_file)) {
                    Storage::disk('public')->delete($file->path_file);
                }
            }
            
            $arsip->delete();

            DB::commit();
            return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus arsip: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form 'create' dengan data yang sudah diisi (duplikat).
     */
    public function duplicate(Arsip $arsip)
    {
        $arsip->load('uraianIsiInformasi', 'files');
        $data = $this->getFormDropdownData();
        $data['arsip'] = $arsip;
        $data['isDuplicate'] = true;

        return view('arsip.create', $data);
    }
    
    /**
     * API: Mengambil detail JRA untuk form.
     */
    public function getKlasifikasiDetail($id)
    {
        $data = KlasifikasiSurat::find($id);
        return response()->json($data);
    }
    
    /**
     * Mengambil data dropdown untuk form create/edit.
     */
    private function getFormDropdownData()
    {
        $user = Auth::user();
        $data = [];

        $data['klasifikasi_list'] = KlasifikasiSurat::orderBy('kode_klasifikasi')->get();

        $data['allDivisi'] = ($user->role === 'Admin') 
            ? Divisi::where('id', '!=', 1)->orderBy('nama')->get() 
            : collect();
        
        $data['bentuk_naskah_list'] = BentukNaskah::orderBy('nama_bentuk_naskah')->get();
        
        return $data;
    }
}