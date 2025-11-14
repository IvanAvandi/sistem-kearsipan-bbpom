<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsulanPindahController extends Controller
{
    /**
     * Menampilkan halaman daftar riwayat usulan pindah.
     */
    public function index()
    {
        return view('usul-pindah.index');
    }

}