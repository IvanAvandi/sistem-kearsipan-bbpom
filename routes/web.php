<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KlasifikasiSuratController;
use App\Http\Controllers\Admin\BentukNaskahController;
use App\Http\Controllers\Admin\LinkTerkaitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\PusatTemplateController;
use App\Http\Controllers\Admin\UsulanPemusnahanController;
use App\Http\Controllers\UsulanPindahController;
use App\Http\Controllers\Admin\UsulanPindahController as AdminUsulanPindahController;

use App\Http\Livewire\UsulanPindahShow;
use App\Http\Livewire\Admin\UsulanPemusnahanShow;
use App\Http\Livewire\Admin\UsulanPindahShow as AdminUsulanPindahShow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam grup yang berisi
| middleware "web". Buatlah sesuatu yang hebat!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

// --- GROUP UNTUK PENGGUNA YANG SUDAH LOGIN (SEMUA ROLE) ---
Route::middleware(['auth'])->group(function() {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Rute Terkait Arsip ---
    Route::resource('arsip', ArsipController::class)->except(['destroy']);
    Route::delete('/arsip/{arsip}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
    Route::get('/arsip/{arsip}/duplicate', [ArsipController::class, 'duplicate'])->name('arsip.duplicate');
    Route::get('/api/klasifikasi/{id}', [ArsipController::class, 'getKlasifikasiDetail']);

    // --- Rute Terkait Template ---
    Route::get('/pusat-template', [PusatTemplateController::class, 'index'])->name('pusat-template.index');

    // --- Rute Usulan Pemusnahan (Admin) ---
    Route::prefix('admin/usulan-pemusnahan')->name('admin.usulan-pemusnahan.')->group(function() {
        Route::get('/', [UsulanPemusnahanController::class, 'index'])->name('index');
        Route::get('/{usulanPemusnahan}', UsulanPemusnahanShow::class)->name('show');
        Route::get('/{usulan}/cetak-excel', [UsulanPemusnahanController::class, 'cetakExcel'])->name('cetak-excel');
    });

    // --- Rute Usul Pindah (Arsiparis) ---
    Route::prefix('usul-pindah')->name('usul-pindah.')->middleware('cekrole:Arsiparis')->group(function() {
        Route::get('/', [UsulanPindahController::class, 'index'])->name('index'); 
        Route::get('/{usulanPindah}', UsulanPindahShow::class)->name('show');
    });

    // --- GROUP KHUSUS UNTUK ROLE ADMIN ---
    Route::middleware(['auth', 'cekrole:Admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::get('/pengaturan', function() { return view('admin.pengaturan.index'); })->name('pengaturan.index'); 
        Route::get('pengaturan/users', function () { return view('admin.users.index'); })->name('users.index'); 
        
        Route::resource('klasifikasi', KlasifikasiSuratController::class);
        Route::resource('bentuk-naskah', BentukNaskahController::class);
        Route::resource('link-terkait', LinkTerkaitController::class);
        Route::resource('templates', TemplateController::class);
        
        // --- Rute Peninjauan Usulan Pindah (Admin) ---
        Route::get('review-pindah', [AdminUsulanPindahController::class, 'index'])->name('usul-pindah-review.index');
        Route::get('review-pindah/{usulanPindah}', AdminUsulanPindahShow::class)->name('usul-pindah.show');
    
    });
    
});