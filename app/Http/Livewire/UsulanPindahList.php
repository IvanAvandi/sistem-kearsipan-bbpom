<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UsulanPindah;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsulanPindahExport;

class UsulanPindahList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'triggerHapusDraft' => 'hapusDraft',
        'triggerBatalkanUsulan' => 'batalkanUsulan'
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    
    /**
     * Hapus Usulan Draft atau Dikembalikan
     */
    public function hapusDraft($usulanId) // Terima $usulanId dari event
    {
        $usulan = UsulanPindah::with('arsips.klasifikasiSurat')
            ->where('id', $usulanId)
            ->whereHas('user', fn($q) => $q->where('divisi_id', Auth::user()->divisi_id)) 
            ->first();

        if (!$usulan || !in_array($usulan->status, ['Draft', 'Dikembalikan'])) {
            $this->dispatchBrowserEvent('swal:alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'text' => 'Usulan tidak ditemukan atau status tidak diizinkan untuk dihapus/dibatalkan.'
            ]);
            return;
        }

        DB::transaction(function () use ($usulan) {
            foreach($usulan->arsips as $arsip) {
                    if ($arsip->klasifikasiSurat) {
                        $tanggalInaktif = Carbon::parse($arsip->tanggal_arsip)->addYears($arsip->klasifikasiSurat->masa_aktif);
                        $statusAsli = Carbon::now()->lt($tanggalInaktif) ? 'Aktif' : 'Inaktif';
                        $arsip->update(['status' => $statusAsli]);
                    }
            }
            if ($usulan->file_ba_path && Storage::disk('public')->exists($usulan->file_ba_path)) {
                Storage::disk('public')->delete($usulan->file_ba_path);
            }
            $usulan->delete();
        });

        $this->dispatchBrowserEvent('swal:alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Usulan berhasil dihapus dan status arsip dikembalikan.'
        ]);
    }

    /**
     * Batalkan Usulan yang Diajukan
     */
    public function batalkanUsulan($usulanId) // Terima $usulanId dari event
    {
        $usulan = UsulanPindah::with('arsips.klasifikasiSurat')
            ->where('id', $usulanId)
            ->whereHas('user', fn($q) => $q->where('divisi_id', Auth::user()->divisi_id)) 
            ->first();

        if (!$usulan || $usulan->status !== 'Diajukan') {
            $this->dispatchBrowserEvent('swal:alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'text' => 'Usulan tidak ditemukan atau hanya usulan yang sudah diajukan yang bisa dibatalkan.'
            ]);
            return;
        }

        DB::transaction(function () use ($usulan) {
            foreach($usulan->arsips as $arsip) {
                    if ($arsip->klasifikasiSurat) {
                        $tanggalInaktif = Carbon::parse($arsip->tanggal_arsip)->addYears($arsip->klasifikasiSurat->masa_aktif);
                        $statusAsli = Carbon::now()->lt($tanggalInaktif) ? 'Aktif' : 'Inaktif';
                        $arsip->update(['status' => $statusAsli]);
                    }
            }
            
            $usulan->update([
                'status' => 'Dibatalkan',
                'dibatalkan_pada' => Carbon::now(),
                'dibatalkan_oleh_id' => Auth::id(),
            ]);
        });

        $this->dispatchBrowserEvent('swal:alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Usulan berhasil dibatalkan dan arsip dikembalikan.'
        ]);
    }

    /**
     * Download BA (Excel)
     */
    public function exportBA($usulanId)
    {
        $usulan = UsulanPindah::find($usulanId);
        
        if (!$usulan || $usulan->user->divisi_id !== Auth::user()->divisi_id) {
             $this->dispatchBrowserEvent('swal:alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'text' => 'Usulan tidak ditemukan.'
            ]);
             return;
        }
        
        $fileName = 'BA_Pindah_Arsip_' . $usulan->id . '_' . now()->format('Ymd') . '.xlsx';
        return Excel::download(new UsulanPindahExport($usulan), $fileName);
    }

    public function render()
    {
        $query = UsulanPindah::with(['user:id,name,divisi_id', 'user.divisi:id,nama'])
            ->withCount('arsips') 
            ->whereHas('user', fn($q) => $q->where('divisi_id', Auth::user()->divisi_id)) 
            ->when($this->search, function($q) {
                $q->where('nomor_ba', 'like', '%'.$this->search.'%');
            })
            ->when($this->status, function($q) {
                $q->where('status', $this->status);
            });

        $usulans = $query->latest()->paginate(10);

        return view('livewire.usulan-pindah-list', [
            'usulans' => $usulans
        ]);
    }
}