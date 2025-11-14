<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UsulanPindah;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsulanPindahExport;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;

/**
 * Mengelola tampilan detail dan semua aksi untuk Usulan Pindah (sisi Arsiparis).
 *
 * @package App\Http\Livewire
 */
class UsulanPindahShow extends Component
{
    use WithPagination, WithFileUploads;

    public UsulanPindah $usulan;
    public $showUploadBaModal = false;
    public $nomor_ba;
    public $tanggal_ba;
    public $file_ba;
    public $selectedArsip = [];
    public $selectAll = false;
    public Collection $arsipList;
    
    protected $listeners = [
        'triggerAjukanUlang' => 'ajukanUlang',
        'triggerHapusDraft' => 'hapusDraft',
        'triggerBatalkan' => 'batalkan',
        'triggerRemoveSelectedArsips' => 'removeSelectedArsips',
    ];

    /**
     * Inisialisasi komponen.
     */
    public function mount(UsulanPindah $usulanPindah)
    {
        // Validasi hak akses (hanya pembuat yang boleh buka)
        if ($usulanPindah->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Usulan ini bukan milik Anda.');
        }

        $this->usulan = $usulanPindah->load(
            'user.divisi', 
            'arsips.klasifikasiSurat',
            'diusulkanOleh:id,name',
            'dikembalikanOleh:id,name',
            'disetujuiOleh:id,name',
            'dibatalkanOleh:id,name'
        );
        $this->loadArsipList();
    }

    /**
     * Memuat daftar arsip (non-paginasi) ke properti.
     */
    public function loadArsipList()
    {
        $this->arsipList = $this->usulan->arsips()->get();
        $this->selectedArsip = [];
        $this->selectAll = false;
    }

    /**
     * Membuka modal untuk upload/edit Berita Acara.
     */
    public function openUploadBaModal()
    {
        $this->resetErrorBag();
        $this->nomor_ba = (strpos($this->usulan->nomor_ba, 'DRAFT-BA-') === 0) ? '' : $this->usulan->nomor_ba;
        $this->tanggal_ba = $this->usulan->tanggal_ba ? $this->usulan->tanggal_ba->format('Y-m-d') : now()->format('Y-m-d');
        $this->file_ba = null;
        $this->showUploadBaModal = true;
    }

    /**
     * Aksi: Menyimpan/Update Berita Acara.
     */
    public function updateBA()
    {
        $this->validate([
            'nomor_ba' => 'required|string|max:255',
            'tanggal_ba' => 'required|date',
            'file_ba' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $filePath = $this->usulan->file_ba_path;
        if ($this->file_ba) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $this->file_ba->store('berita_acara_pindah', 'public');
        }

        $this->usulan->update([
            'nomor_ba' => $this->nomor_ba,
            'tanggal_ba' => $this->tanggal_ba,
            'file_ba_path' => $filePath,
        ]);

        $this->showUploadBaModal = false;
        $this->dispatchBrowserEvent('swal:alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Berita Acara berhasil diperbarui.'
        ]);
        $this->usulan->refresh();
    }

    /**
     * Logika untuk Select All Checkbox.
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedArsip = $this->arsipList->pluck('id')->map(fn($id) => (string) $id)->all();
        } else {
            $this->selectedArsip = [];
        }
    }

    /**
     * PERBAIKAN: Aksi menghapus arsip dari draf.
     * Jika arsip habis, hapus draf.
     */
    public function removeSelectedArsips()
    {
        if (empty($this->selectedArsip)) return;

        if (!in_array($this->usulan->status, ['Draft', 'Dikembalikan'])) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Arsip hanya bisa dihapus saat status usulan Draft atau Dikembalikan.']);
            return;
        }

        $arsipIdsToRestore = $this->selectedArsip;
        $shouldRedirect = false;

        DB::beginTransaction();
        try {
            // 1. Kembalikan status arsip-arsip ini
            $arsips = Arsip::with('klasifikasiSurat')->whereIn('id', $arsipIdsToRestore)->get();
            foreach ($arsips as $arsip) {
                if ($arsip->klasifikasiSurat) {
                    $tanggalInaktif = Carbon::parse($arsip->tanggal_arsip)->addYears($arsip->klasifikasiSurat->masa_aktif);
                    $statusAsli = Carbon::now()->lt($tanggalInaktif) ? 'Aktif' : 'Inaktif';
                    $arsip->update(['status' => $statusAsli]);
                } else {
                    $arsip->update(['status' => 'Inaktif']); // Fallback
                }
            }

            // 2. Detach (hapus) arsip dari usulan ini
            $this->usulan->arsips()->detach($arsipIdsToRestore);

            // 3. Muat ulang hitungan relasi
            $this->usulan->loadCount('arsips');

            // 4. Cek jika arsip habis (count == 0)
            if ($this->usulan->arsips_count === 0) {
                if ($this->usulan->file_ba_path && Storage::disk('public')->exists($this->usulan->file_ba_path)) {
                    Storage::disk('public')->delete($this->usulan->file_ba_path);
                }
                $this->usulan->delete();
                $shouldRedirect = true;
            }
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Error!', 'text' => 'Gagal menghapus arsip: ' . $e->getMessage()]);
            return;
        }

        // 5. Kirim feedback
        if ($shouldRedirect) {
            $this->dispatchBrowserEvent('swal:redirect', [
                'url' => route('usul-pindah.index'),
                'message' => 'Arsip terakhir telah dihapus, draf usulan berhasil dihapus.'
            ]);
        } else {
            $this->loadArsipList(); 
            $this->dispatchBrowserEvent('swal:alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'text' => count($arsipIdsToRestore) . ' arsip telah dihapus dari usulan ini dan dikembalikan ke daftar arsip.'
            ]);
        }
    }

    /**
     * Aksi: Mengajukan (atau mengajukan ulang) usulan.
     */
    public function ajukanUlang()
    {
        if (!in_array($this->usulan->status, ['Draft', 'Dikembalikan'])) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Hanya usulan Draft atau Dikembalikan yang bisa diajukan.']);
            return;
        }
        if (empty($this->usulan->file_ba_path) || strpos($this->usulan->nomor_ba, 'DRAFT-BA-') === 0 || empty($this->usulan->nomor_ba)) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Data Berita Acara (Nomor, Tanggal, dan File) harus dilengkapi sebelum diajukan.']);
            return;
        }
        
        if ($this->arsipList->count() === 0) {
             $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Tidak ada arsip dalam usulan ini. Hapus draft jika tidak diperlukan.']);
            return;
        }
        
        DB::beginTransaction();
        try {
            $arsipIdsToSubmit = $this->arsipList->pluck('id');
            Arsip::whereIn('id', $arsipIdsToSubmit)->update(['status' => 'Diusulkan Pindah']);

            $this->usulan->update([
                'status' => 'Diajukan',
                'diajukan_pada' => Carbon::now(),
                'diusulkan_oleh_id' => Auth::id(), 
                'catatan_admin' => null,
                'dikembalikan_pada' => null,
                'dikembalikan_oleh_id' => null,
            ]);
            
            DB::commit();
            
            $this->usulan->refresh();
            $this->dispatchBrowserEvent('swal:alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'text' => 'Usulan Pindah berhasil diajukan ke Tata Usaha.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Error!', 'text' => 'Gagal mengajukan ulang: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Aksi: Menghapus draf usulan.
     */
    public function hapusDraft()
    {
        if ($this->usulan->status !== 'Draft') {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Hanya usulan Draft yang bisa dihapus.']);
            return;
        }
        
        DB::transaction(function () {
            $this->kembalikanSemuaStatusArsip();
            
            if ($this->usulan->file_ba_path && Storage::disk('public')->exists($this->usulan->file_ba_path)) {
                Storage::disk('public')->delete($this->usulan->file_ba_path);
            }
            $this->usulan->delete();
        });

        $this->dispatchBrowserEvent('swal:redirect', [
            'url' => route('usul-pindah.index'),
            'message' => 'Draft usulan berhasil dihapus dan arsip dikembalikan.'
        ]);
    }

    /**
     * Aksi: Membatalkan usulan yang sudah diajukan/dikembalikan.
     */
    public function batalkan()
    {
        if (!in_array($this->usulan->status, ['Dikembalikan', 'Diajukan'])) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Usulan ini tidak dapat dibatalkan.']);
            return;
        }
        
        DB::transaction(function () {
            $this->kembalikanSemuaStatusArsip();
            
            $this->usulan->update([
                'status' => 'Dibatalkan',
                'dibatalkan_pada' => Carbon::now(),
                'dibatalkan_oleh_id' => Auth::id(),
            ]);
        });
        
        $this->usulan->refresh();
        $this->dispatchBrowserEvent('swal:alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Usulan berhasil dibatalkan dan arsip dikembalikan.'
        ]);
    }

    /**
     * Logika internal untuk mengembalikan status arsip (DRY).
     */
    private function kembalikanSemuaStatusArsip()
    {
        $allArsipIds = $this->usulan->arsips()->pluck('arsip.id')->toArray();
        if (count($allArsipIds) === 0) return;

        $arsipsToRestore = Arsip::with('klasifikasiSurat')->whereIn('id', $allArsipIds)->get();

        foreach ($arsipsToRestore as $arsip) {
             if ($arsip->klasifikasiSurat) {
                 $tanggalInaktif = Carbon::parse($arsip->tanggal_arsip)->addYears($arsip->klasifikasiSurat->masa_aktif);
                 $statusAsli = Carbon::now()->lt($tanggalInaktif) ? 'Aktif' : 'Inaktif';
                 $arsip->update(['status' => $statusAsli]);
             } else {
                 $arsip->update(['status' => 'Inaktif']); // Fallback
             }
        }
    }

    /**
     * Aksi: Ekspor Excel
     */
    public function exportBA()
    {
        $this->usulan->setRelation('arsips', $this->arsipList);
        
        $fileName = 'BA_Pindah_Arsip_' . $this->usulan->id . '_' . now()->format('Ymd') . '.xlsx';
        return Excel::download(new UsulanPindahExport($this->usulan), $fileName);
    }

    /**
     * Render tampilan.
     */
    public function render()
    {
        return view('livewire.usulan-pindah-show');
    }
}