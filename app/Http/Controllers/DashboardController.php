<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\LinkTerkait;
use App\Models\UsulanPindah; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Scopes\DivisiScope;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $arsipQuery = $user->role === 'Admin'
            ? Arsip::withoutGlobalScope(DivisiScope::class) // Admin melihat semua
            : Arsip::query(); // Arsiparis otomatis terfilter oleh scope

        // --- 1. Hitung Peringatan (Untuk Tab) ---
        $akanInaktifCount = (clone $arsipQuery)->where('status', 'Aktif')
            ->whereHas('klasifikasiSurat', function ($query) {
                 $query->whereRaw('ADDDATE(arsip.tanggal_arsip, INTERVAL masa_aktif YEAR) BETWEEN ? AND ?', [Carbon::now(), Carbon::now()->addDays(30)]);
             })
             ->count();

        $akanSiapMusnahCount = (clone $arsipQuery)->where('status', 'Inaktif')
             ->whereHas('klasifikasiSurat', function ($query) {
                 $query->where('status_akhir', 'Musnah')
                       ->whereRaw('ADDDATE(ADDDATE(arsip.tanggal_arsip, INTERVAL masa_aktif YEAR), INTERVAL masa_inaktif YEAR) BETWEEN ? AND ?', [Carbon::now(), Carbon::now()->addDays(30)]);
             })
             ->count();

        $akanPermanenCount = (clone $arsipQuery)->where('status', 'Inaktif')
             ->whereHas('klasifikasiSurat', function ($query) {
                 $query->where('status_akhir', 'Permanen')
                       ->whereRaw('ADDDATE(ADDDATE(arsip.tanggal_arsip, INTERVAL masa_aktif YEAR), INTERVAL masa_inaktif YEAR) BETWEEN ? AND ?', [Carbon::now(), Carbon::now()->addDays(30)]);
             })
             ->count();


        // --- 2. Hitung Statistik Card Utama (Sama seperti sebelumnya) ---
        $siapDimusnahkanCount = (clone $arsipQuery)->where('status', 'Siap Dimusnahkan')->count();
        $arsipAktifCount = (clone $arsipQuery)->where('status', 'Aktif')->count();
        $arsipPermanenCount = (clone $arsipQuery)->where('status', 'Permanen')->count();
        $arsipInaktifCount = (clone $arsipQuery)->where('status', 'Inaktif')->count();

        // --- 3. Hitung Statistik Usulan Pindah (Hanya untuk ARSIPARIS) ---
        $usulanBaseQuery = UsulanPindah::where('user_id', $user->id); // Filter berdasarkan user yang login

        $usulanDraftCount = (clone $usulanBaseQuery)->where('status', 'Draft')->count();
        $usulanDiajukanCount = (clone $usulanBaseQuery)->where('status', 'Diajukan')->count();
        $usulanDikembalikanCount = (clone $usulanBaseQuery)->where('status', 'Dikembalikan')->count();
        $usulanSelesaiCount = (clone $usulanBaseQuery)->where('status', 'Selesai')->count();


        // --- 4. Data Chart & List ---
        $arsipStatusStats = (clone $arsipQuery)->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $arsipTerbaru = (clone $arsipQuery)->with(['klasifikasiSurat', 'divisi'])
            ->latest()
            ->take(5)
            ->get();

        // --- 5. Data Link Terkait ---
        $linksTerkait = LinkTerkait::where('status', 'Aktif')->orderBy('nama', 'asc')->get();


        return view('dashboard', compact(
            'siapDimusnahkanCount',
            'arsipAktifCount',
            'arsipPermanenCount',
            'arsipInaktifCount',
            'akanInaktifCount',
            'akanSiapMusnahCount',
            'akanPermanenCount',
            'arsipStatusStats',
            'arsipTerbaru',
            'linksTerkait',
            'usulanDraftCount',
            'usulanDiajukanCount',
            'usulanDikembalikanCount',
            'usulanSelesaiCount'
        ));
    }
}