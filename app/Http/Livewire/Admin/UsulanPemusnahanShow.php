<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\UsulanPemusnahan;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\UsulMusnahExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

/**
 * Mengelola tampilan detail dan semua aksi untuk Usulan Pemusnahan.
 *
 * @package App\Http\Livewire\Admin
 */
class UsulanPemusnahanShow extends Component
{
    use WithFileUploads;
    use WithPagination;

    public UsulanPemusnahan $usulan;
    protected $paginationTheme = 'tailwind';

    // --- Properti untuk Status 'Draft' ---
    public $selectedArsip = [];
    public $selectAll = false;
    public $showUploadSuratModal = false;
    public $nomor_surat_usulan;
    public $tanggal_surat_usulan;
    public $file_surat_usulan;

    // --- Properti Modal Status Lanjutan ---
    public $showLaksanakanModal = false;
    public $nomor_surat_persetujuan;
    public $tanggal_surat_persetujuan;
    public $tanggal_pemusnahan_fisik;
    public $file_surat_persetujuan;

    public $showArsipkanBapaModal = false;
    public $nomor_bapa_diterima;
    public $tanggal_bapa_diterima;
    public $file_bapa_diterima;

    public $showTolakModal = false;
    public $nomor_surat_penolakan;
    public $tanggal_surat_penolakan;
    public $file_surat_penolakan;
    public $catatan_penolakan;

    /**
     * Listeners untuk SweetAlert
     */
    protected $listeners = [
        'triggerAjukan' => 'ajukan',
        'triggerHapusDraft' => 'hapusDraft',
        'triggerBatalkan' => 'batalkanUsulan',
        'triggerRemoveSelectedArsips' => 'removeSelectedArsips',
    ];

    /**
     * Aturan validasi untuk 'Laksanakan Pemusnahan'
     */
    protected $rulesLaksanakan = [
        'nomor_surat_persetujuan'   => 'required|string|max:255',
        'tanggal_surat_persetujuan' => 'required|date',
        'tanggal_pemusnahan_fisik'  => 'required|date',
        'file_surat_persetujuan'    => 'nullable|file|mimes:pdf|max:2048',
    ];

    /**
     * Aturan validasi dinamis berdasarkan modal yang aktif.
     */
    protected function rules()
    {
        if ($this->showArsipkanBapaModal) {
            return [
                'nomor_bapa_diterima'   => 'required|string|max:255',
                'tanggal_bapa_diterima' => 'required|date',
                'file_bapa_diterima'    => 'nullable|file|mimes:pdf|max:2048',
            ];
        }
        if ($this->showTolakModal) {
             return [
                'nomor_surat_penolakan'   => 'required|string|max:255',
                'tanggal_surat_penolakan' => 'required|date',
                'file_surat_penolakan'    => 'nullable|file|mimes:pdf|max:2048',
                'catatan_penolakan'       => 'nullable|string',
            ];
        }
        if ($this->showUploadSuratModal) {
             return [
                'nomor_surat_usulan'   => 'required|string|max:255',
                'tanggal_surat_usulan' => 'required|date',
                'file_surat_usulan'    => $this->usulan->file_surat_usulan_path && !$this->file_surat_usulan
                                            ? 'nullable|mimes:pdf|max:2048'
                                            : 'required|file|mimes:pdf|max:2048',
            ];
        }
        return [];
    }

    /**
     * Inisialisasi komponen.
     */
    public function mount(UsulanPemusnahan $usulanPemusnahan)
    {
        $this->usulan = $usulanPemusnahan->load(
            'user.divisi', 
            'arsips.klasifikasiSurat'
        );
    }
    
    /**
     * Mengambil daftar arsip dengan paginasi.
     */
    public function getArsipListProperty()
    {
        return $this->usulan->arsips()
            ->with(['klasifikasiSurat' => fn ($query) => $query->withTrashed()])
            ->paginate(10);
    }
    
    /**
     * Logika untuk Select All Checkbox.
     */
    public function updatingSelectAll($value)
    {
        if ($value) {
            $this->selectedArsip = $this->arsipList->pluck('id')->map(fn ($id) => (string) $id)->all();
        } else {
            $this->selectedArsip = [];
        }
    }

    /**
     * Aksi: Menghapus arsip yang dipilih dari draf.
     * Jika arsip habis, hapus draf.
     */
    public function removeSelectedArsips()
    {
        if ($this->usulan->status !== 'Draft') {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Aksi tidak diizinkan.']);
            return;
        }

        $shouldRedirect = false; 

        DB::transaction(function () use (&$shouldRedirect) {
            Arsip::whereIn('id', $this->selectedArsip)->update(['status' => 'Siap Dimusnahkan']);
            $this->usulan->arsips()->detach($this->selectedArsip);
            $this->usulan->loadCount('arsips'); 

            if ($this->usulan->arsips_count === 0) {
                if ($this->usulan->file_surat_usulan_path && Storage::disk('public')->exists($this->usulan->file_surat_usulan_path)) {
                    Storage::disk('public')->delete($this->usulan->file_surat_usulan_path);
                }
                $this->usulan->delete();
                $shouldRedirect = true;
            }
        });

        if ($shouldRedirect) {
            $this->dispatchBrowserEvent('swal:redirect', [
                'url' => route('admin.usulan-pemusnahan.index'),
                'message' => 'Arsip terakhir telah dihapus, draf usulan berhasil dihapus.'
            ]);
        } else {
            $this->selectedArsip = [];
            $this->selectAll = false;
            $this->usulan->refresh();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Arsip terpilih telah dihapus dari draf.']);
        }
    }

    /**
     * Aksi: Membuka modal untuk upload surat usulan.
     */
    public function openUploadSuratModal()
    {
        $this->resetErrorBag();
        $this->nomor_surat_usulan   = $this->usulan->nomor_surat_usulan;
        $this->tanggal_surat_usulan = $this->usulan->tanggal_surat_usulan;
        $this->file_surat_usulan    = null;
        $this->showUploadSuratModal = true;
    }

    /**
     * Aksi: Menyimpan/Update detail surat usulan.
     */
    public function updateSuratUsulan()
    {
        $this->validate(); 

        $filePath = $this->usulan->file_surat_usulan_path;
        if ($this->file_surat_usulan) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $this->file_surat_usulan->store('surat_usulan_musnah', 'public');
        }

        $this->usulan->update([
            'nomor_surat_usulan'   => $this->nomor_surat_usulan,
            'tanggal_surat_usulan' => $this->tanggal_surat_usulan,
            'file_surat_usulan_path' => $filePath,
        ]);

        $this->showUploadSuratModal = false;
        $this->usulan->refresh();
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Detail surat usulan berhasil diperbarui.']);
    }

    /**
     * Aksi: Mengajukan usulan ke Pusat.
     */
    public function ajukan()
    {
        if ($this->usulan && $this->usulan->status == 'Draft') {
            
            if (empty($this->usulan->nomor_surat_usulan) || empty($this->usulan->tanggal_surat_usulan) || empty($this->usulan->file_surat_usulan_path)) {
                $this->dispatchBrowserEvent('swal:alert', [
                    'type' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'Harap lengkapi detail Surat Usulan (nomor, tanggal, dan file) sebelum mengajukan.'
                ]);
                return;
            }

            $this->usulan->update(['status' => 'Diajukan ke Pusat']);
            $this->usulan->refresh();
            
            $this->dispatchBrowserEvent('swal:alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'text' => 'Usulan berhasil diajukan ke Pusat.'
            ]);
        } else {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Aksi tidak valid.']);
        }
    }

    /**
     * Aksi: Menghapus Draf.
     */
    public function hapusDraft()
    {
        if (!$this->usulan || $this->usulan->status !== 'Draft') {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Hanya draf usulan yang bisa dihapus.']);
            return;
        }

        DB::transaction(function () {
            $arsipIds = $this->usulan->arsips->pluck('id');
            Arsip::whereIn('id', $arsipIds)->update(['status' => 'Siap Dimusnahkan']);
            
            if ($this->usulan->file_surat_usulan_path && Storage::disk('public')->exists($this->usulan->file_surat_usulan_path)) {
                Storage::disk('public')->delete($this->usulan->file_surat_usulan_path);
            }

            $this->usulan->delete();
        });

        $this->dispatchBrowserEvent('swal:redirect', [
            'url' => route('admin.usulan-pemusnahan.index'),
            'message' => 'Draft usulan berhasil dihapus dan arsip dikembalikan.'
        ]);
    }

    /**
     * Aksi: Membatalkan Usulan yang sudah diajukan.
     */
    public function batalkanUsulan()
    {
        if (!$this->usulan || $this->usulan->status !== 'Diajukan ke Pusat') {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Hanya usulan yang sudah diajukan yang bisa dibatalkan.']);
            return;
        }

        DB::transaction(function () {
            $arsipIds = $this->usulan->arsips->pluck('id');
            Arsip::whereIn('id', $arsipIds)->update(['status' => 'Siap Dimusnahkan']);
            $this->usulan->update(['status' => 'Dibatalkan']);
        });

        $this->usulan->refresh();
        $this->dispatchBrowserEvent('swal:alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Usulan berhasil dibatalkan dan arsip dikembalikan.'
        ]);
    }

    // --- LOGIKA MODAL TOLAK ---
    public function openTolakModal()
    {
        $this->resetErrorBag();
        $this->reset(['nomor_surat_penolakan', 'tanggal_surat_penolakan', 'file_surat_penolakan', 'catatan_penolakan']);
        $this->showTolakModal = true;
    }

    public function tolakUsulan()
    {
        $this->validate($this->rules()); 

        if (!$this->usulan || $this->usulan->status !== 'Diajukan ke Pusat') {
            $this->showTolakModal = false;
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Aksi tidak valid.']);
            return;
        }

        $filePath = null;
        if ($this->file_surat_penolakan) {
            $filePath = $this->file_surat_penolakan->store('surat_penolakan', 'public');
        }

        DB::transaction(function () use ($filePath) {
            $arsipIds = $this->usulan->arsips()->pluck('arsip.id');
            Arsip::whereIn('id', $arsipIds)->update(['status' => 'Siap Dimusnahkan']);

            $this->usulan->update([
                'status' => 'Ditolak',
                'nomor_surat_penolakan' => $this->nomor_surat_penolakan,
                'tanggal_surat_penolakan' => $this->tanggal_surat_penolakan,
                'file_surat_penolakan_path' => $filePath,
                'catatan_penolakan' => $this->catatan_penolakan,
            ]);
        });

        $this->showTolakModal = false;
        $this->usulan->refresh();
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Penolakan usulan berhasil dicatat.']);
    }

    // --- LOGIKA MODAL LAKSANAKAN ---
    public function openLaksanakanModal()
    {
        $this->resetErrorBag();
        $this->reset(['nomor_surat_persetujuan', 'tanggal_surat_persetujuan', 'file_surat_persetujuan']);
        $this->tanggal_pemusnahan_fisik = now()->format('Y-m-d');
        $this->showLaksanakanModal = true;
    }

    public function laksanakanPemusnahan()
    {
        $this->validate($this->rulesLaksanakan);

        $filePathPersetujuan = null;
        if ($this->file_surat_persetujuan) {
            $filePathPersetujuan = $this->file_surat_persetujuan->store('surat_persetujuan', 'public');
        }

        DB::transaction(function () use ($filePathPersetujuan) {
            $this->usulan->update([
                'nomor_surat_persetujuan'   => $this->nomor_surat_persetujuan,
                'tanggal_surat_persetujuan' => $this->tanggal_surat_persetujuan,
                'tanggal_pemusnahan_fisik'  => $this->tanggal_pemusnahan_fisik,
                'file_surat_persetujuan_path' => $filePathPersetujuan,
                'status' => 'Musnah, Menunggu BA',
            ]);

            $arsipsToMusnahkan = $this->usulan->arsips()->with('files')->get(); 

            foreach ($arsipsToMusnahkan as $arsip) {
                if ($arsip->files) {
                     foreach ($arsip->files as $file) {
                         if ($file->path_file && Storage::disk('public')->exists($file->path_file)) {
                             Storage::disk('public')->delete($file->path_file);
                         }
                         $file->delete();
                     }
                }
                $arsip->link_eksternal = null;
                $arsip->status = 'Musnah';
                $arsip->save();
            }
        });

        $this->showLaksanakanModal = false;
        $this->usulan->refresh();
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Pemusnahan berhasil dicatat.']);
    }

    // --- LOGIKA MODAL ARSIPKAN BAPA ---
    public function openArsipkanBapaModal()
    {
        $this->resetErrorBag();
        $this->reset(['nomor_bapa_diterima', 'tanggal_bapa_diterima', 'file_bapa_diterima']);
        $this->showArsipkanBapaModal = true;
    }

    public function arsipkanBapaFinal()
    {
        $this->validate($this->rules());

        $filePath = null;
        if ($this->file_bapa_diterima) {
            $filePath = $this->file_bapa_diterima->store('bapa_final', 'public');
        }

        $this->usulan->update([
            'nomor_bapa_diterima'   => $this->nomor_bapa_diterima,
            'tanggal_bapa_diterima' => $this->tanggal_bapa_diterima,
            'file_bapa_diterima_path' => $filePath,
            'status' => 'Selesai',
        ]);

        $this->showArsipkanBapaModal = false;
        $this->usulan->refresh();
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success', 'title' => 'Berhasil!', 'text' => 'Berita Acara berhasil diarsipkan.']);
    }

    /**
     * Aksi: Ekspor Excel
     */
    public function cetakExcel()
    {
        $fileName = 'Usul_Musnah_' . str_replace('/', '_', $this->usulan->nomor_usulan) . '.xlsx';
        return Excel::download(new UsulMusnahExport($this->usulan), $fileName);
    }

    /**
     * Render tampilan.
     */
    public function render()
    {
        return view('livewire.admin.usulan-pemusnahan-show', [
            'arsipList' => ($this->usulan->status == 'Draft') 
                            ? $this->arsipList 
                            : $this->usulan->arsips,
        ]);
    }
}