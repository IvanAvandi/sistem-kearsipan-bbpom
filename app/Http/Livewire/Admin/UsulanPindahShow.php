<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\UsulanPindah;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Mengelola tampilan detail dan semua aksi untuk Usulan Pindah (sisi Admin).
 *
 * @package App\Http\Livewire\Admin
 */
class UsulanPindahShow extends Component
{
    public UsulanPindah $usulan;
    
    /**
     * @var bool Status tampil modal "Kembalikan".
     */
    public $showKembalikanModal = false;
    
    /**
     * @var string Catatan admin untuk revisi.
     */
    public $catatan_admin = '';

    /**
     * Listeners untuk SweetAlert
     */
    protected $listeners = [
        'triggerSetujui' => 'setujui',
        'triggerKembalikan' => 'kembalikan'
    ];

    /**
     * Aturan validasi untuk modal.
     */
    protected $rules = [
        'catatan_admin' => 'required|string|min:5',
    ];

    /**
     * Pesan validasi kustom.
     */
    protected $messages = [
        'catatan_admin.required' => 'Catatan revisi wajib diisi saat mengembalikan usulan.'
    ];

    /**
     * Inisialisasi komponen.
     */
    public function mount(UsulanPindah $usulanPindah)
    {
        $this->usulan = $usulanPindah->load(
            'user.divisi', 
            'arsips.klasifikasiSurat',
            'diusulkanOleh:id,name',
            'dikembalikanOleh:id,name',
            'disetujuiOleh:id,name',
            'dibatalkanOleh:id,name'
        );
    }

    /**
     * Aksi: Membuka Modal Kembalikan
     */
    public function openKembalikanModal()
    {
        $this->resetErrorBag();
        $this->catatan_admin = '';
        $this->showKembalikanModal = true;
    }

    /**
     * Aksi: Menyetujui Usulan Pindah (Dipicu oleh SweetAlert)
     */
    public function setujui()
    {
        if ($this->usulan->status !== 'Diajukan') {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Usulan ini tidak valid atau sudah diproses.']);
            return;
        }

        DB::beginTransaction();
        try {
            // 1. Update status usulan
            $this->usulan->update([
                'status' => 'Selesai',
                'catatan_admin' => null,
                'disetujui_pada' => Carbon::now(),
                'disetujui_oleh_id' => Auth::id(),
                'dikembalikan_pada' => null,
                'dikembalikan_oleh_id' => null,
            ]);

            // 2. Update arsip terkait
            foreach ($this->usulan->arsips as $arsip) {
                // Tentukan status asli (Aktif/Inaktif) berdasarkan JRA
                $tanggalInaktif = Carbon::parse($arsip->tanggal_arsip)->addYears($arsip->klasifikasiSurat->masa_aktif);
                $statusAsli = Carbon::now()->lt($tanggalInaktif) ? 'Aktif' : 'Inaktif';
                
                $arsip->update([
                    'status' => $statusAsli,
                    'divisi_id' => 2 // ID Divisi Tata Usaha (Admin)
                ]);
            }

            DB::commit();
            
            $this->usulan->refresh();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Usulan Pindah disetujui. Arsip telah dipindahkan.']);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Error!', 'text' => 'Gagal menyetujui: ' . $e->getMessage()]);
        }
    }

    /**
     * Aksi: Mengembalikan Usulan Pindah (Dipicu oleh Modal)
     */
    public function kembalikan()
    {
        $this->validate(); // Validasi $catatan_admin

        if ($this->usulan->status !== 'Diajukan') {
            $this->showKembalikanModal = false;
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Usulan ini tidak valid atau sudah diproses.']);
            return;
        }

        DB::beginTransaction();
        try {
            // 1. Update status usulan
            $this->usulan->update([
                'status' => 'Dikembalikan',
                'catatan_admin' => $this->catatan_admin,
                'dikembalikan_pada' => Carbon::now(),
                'dikembalikan_oleh_id' => Auth::id(),
            ]);
            
            DB::commit();
            
            $this->showKembalikanModal = false;
            $this->usulan->refresh();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Usulan Pindah dikembalikan ke Arsiparis.']);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->showKembalikanModal = false;
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Error!', 'text' => 'Gagal mengembalikan: ' . $e->getMessage()]);
        }
    }

    /**
     * Render tampilan.
     */
    public function render()
    {
        return view('livewire.admin.usulan-pindah-show');
    }
}