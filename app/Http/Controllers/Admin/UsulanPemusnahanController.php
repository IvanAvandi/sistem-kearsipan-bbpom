<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsulanPemusnahan;
use App\Exports\UsulMusnahExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class UsulanPemusnahanController extends Controller
{
    /**
     * Menampilkan halaman index (Tabel Livewire)
     */
    public function index()
    {
        // View ini sekarang HANYA memuat komponen tabel Livewire
        return view('admin.usulan-pemusnahan.index'); 
    }

    public function show(UsulanPemusnahan $usulan)
    {
         return redirect()->route('admin.usulan-pemusnahan.index');
    }

    /**
     * Menangani export Excel (Tetap Diperlukan)
     */
    public function cetakExcel(UsulanPemusnahan $usulan)
    {
        // Muat relasi yang diperlukan untuk export
        $usulan->load('user.divisi', 'arsips.klasifikasiSurat', 'arsips.divisiAsal'); 
        $fileName = 'Usul_Musnah_' . str_replace('/', '_', $usulan->nomor_usulan) . '.xlsx';
        return Excel::download(new UsulMusnahExport($usulan), $fileName);
    }
}