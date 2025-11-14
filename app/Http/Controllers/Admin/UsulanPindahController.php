<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsulanPindah;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsulanPindahController extends Controller
{
    /**
     * Menampilkan halaman daftar review Usulan Pindah (index view).
     */
    public function index()
    {
        return view('admin.usul-pindah.index');
    }

    public function show(UsulanPindah $usulanPindah)
    {
         return redirect()->route('admin.usul-pindah-review.index');
    }

    /**
     * Aksi: Menyetujui Usulan Pindah
     */
    public function setujui(Request $request, UsulanPindah $usulanPindah)
    {
         return redirect()->route('admin.usul-pindah.show', $usulanPindah);
    }

    /**
     * Aksi: Mengembalikan Usulan Pindah (Perlu Revisi)
     */
    public function kembalikan(Request $request, UsulanPindah $usulanPindah)
    {
         return redirect()->route('admin.usul-pindah.show', $usulanPindah);
    }
}