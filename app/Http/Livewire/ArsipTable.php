<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Arsip;
use App\Models\Divisi;
use App\Models\UsulanPemusnahan;
use App\Models\UsulanPindah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\ArsipExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Scopes\DivisiScope;

class ArsipTable extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $status = '';
    public $divisi = ''; 
    public $tahun = '';
    public $sortBy = 'tanggal_arsip';
    public $sortDirection = 'desc';
    public $peringatan = false;
    public $createdBy = ''; 

    public $selectedArsip = [];
    public $selectAll = false;
    public $statusCounts = [];

    public $showExportModal = false;
    public $exportTahun = 'semua';
    public $exportPeriode = 'tahunan';
    public $availableYears = [];

    public $arsipDipindahStatus = 'Dipindahkan ke tata usaha'; 
    private $tataUsahaDivisiId = 2;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'triggerBuatUsulanPindah' => 'buatUsulanPindah',
        'triggerBuatUsulanPemusnahan' => 'buatUsulanPemusnahan'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'divisi' => ['except' => ''],
        'tahun' => ['except' => ''],
        'sortBy' => ['except' => 'tanggal_arsip'],
        'sortDirection' => ['except' => 'desc'],
        'peringatan' => ['except' => false],
        'createdBy' => ['except' => ''],
    ];

    public function mount()
    {
        $this->loadAvailableYears();
    }

    /**
     * Memuat tahun-tahun yang tersedia untuk filter.
     */
    public function loadAvailableYears()
    {
        $query = Arsip::query();
        if (Auth::user()->role !== 'Admin') {
            // Scope DivisiScope sudah otomatis aktif
        }
        $this->availableYears = $query->select(DB::raw('YEAR(tanggal_arsip) as year'))
                                     ->distinct()->orderBy('year', 'desc')->pluck('year')->toArray();
    }

    // --- Resetters ---
    public function updatingSearch() { $this->resetPage(); $this->peringatan = false; }
    public function updatingDivisi() { $this->resetPage(); $this->peringatan = false; }
    public function updatingTahun() { $this->resetPage(); $this->peringatan = false; }
    public function updatingCreatedBy() { $this->resetPage(); $this->peringatan = false; }
    public function updatingStatus() {
        $this->resetPage();
        $this->selectedArsip = [];
        $this->selectAll = false;
        $this->peringatan = false;
    }

    public function resetFilters()
    {
        $this->divisi = '';
        $this->tahun = '';
        $this->resetPage();
    }

    /**
     * Logika Sorting Tabel
     */
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    /**
     * Query utama untuk mengambil data arsip.
     */
    public function arsipsQuery()
    {
        $isArsipDipindah = (Auth::user()->role !== 'Admin' && $this->status === $this->arsipDipindahStatus);

        $query = Arsip::with([
                           'klasifikasiSurat' => fn($q) => $q->withTrashed(),
                           'divisi', 
                           'uraianIsiInformasi',
                           'createdBy',
                           'files'
                       ])
                       ->when($isArsipDipindah, function ($q) {
                           $q->withoutGlobalScope(DivisiScope::class); 
                       })
                       ->when($this->search, function ($q) {
                           $q->where('uraian_berkas', 'like', '%' . $this->search . '%')
                             ->orWhereHas('klasifikasiSurat', fn($qs) => $qs->where('kode_klasifikasi', 'like', '%' . $this->search . '%')->withTrashed());
                       });

        if (Auth::user()->role !== 'Admin') {
            $myDivisiId = Auth::user()->divisi_id;

            if ($this->status === $this->arsipDipindahStatus) {
                // TAB "Dipindahkan ke tata usaha"
                $query->where('divisi_id', $this->tataUsahaDivisiId) 
                      ->where('created_by', Auth::id());
                      
            } else {
                // TAB LAIN (Scope DivisiScope aktif)
                if ($this->status) {
                    $query->where('status', $this->status);
                } else {
                    // TAB "Semua Status" (Arsiparis)
                    // HANYA sembunyikan Diusulkan Musnah
                    $query->whereNotIn('status', [
                        'Diusulkan Musnah',
                    ]);
                }
            }
        } else {
            // LOGIKA ADMIN
            $query->when($this->divisi, fn($q) => $q->where('divisi_id', $this->divisi));
            if ($this->status) {
                $query->where('status', $this->status);
            } else {
                // TAB "Semua Status" (Admin)
                // HANYA sembunyikan Diusulkan Pindah
                $query->whereNotIn('status', [
                    'Diusulkan Pindah', 
                ]);
            }
        }

        $query->when($this->createdBy, fn($q) => $q->where('created_by', $this->createdBy))
              ->when($this->tahun, fn($q) => $q->whereYear('tanggal_arsip', $this->tahun))
              ->when($this->peringatan, function ($q) {
                   return $q->where('status', 'Aktif')
                           ->whereHas('klasifikasiSurat', function ($subQuery) {
                                $subQuery->whereRaw(
                                    'DATE_ADD(tanggal_arsip, INTERVAL masa_aktif YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)'
                                )->withTrashed();
                           });
               });

        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query;
    }

    /**
     * Logika Select All Checkbox
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $query = $this->arsipsQuery();
            if(Auth::user()->role !== 'Admin' && $this->status === 'Inaktif') {
                 $query->where('status', 'Inaktif');
            } elseif (Auth::user()->role === 'Admin' && $this->status === 'Siap Dimusnahkan') {
                $query->where('status', 'Siap Dimusnahkan');
            } else {
                $query->where('id', 0); 
            }
            $arsipsOnPage = $query->paginate(10);
            $this->selectedArsip = $arsipsOnPage->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedArsip = [];
        }
    }

    /**
     * Membuka Modal Ekspor
     */
    public function openExportModal()
    {
        $this->loadAvailableYears(); 
        $this->exportTahun = $this->tahun ?: 'semua';
        $this->exportPeriode = 'tahunan';
        $this->resetErrorBag();
        $this->showExportModal = true;
    }

    /**
     * Aksi Ekspor Excel
     */
    public function export()
    {
        $this->validate([
            'exportTahun' => 'required',
            'exportPeriode' => ['required', Rule::in(['tahunan', 'tw1', 'tw2', 'tw3', 'tw4']),
                Rule::when($this->exportTahun === 'semua', ['in:tahunan'])
            ]
        ]);
        
        $tahunText = $this->exportTahun == 'semua' ? 'SemuaTahun' : $this->exportTahun;
        $periodeText = '';
        if ($this->exportTahun !== 'semua') {
             switch ($this->exportPeriode) {
                 case 'tw1': $periodeText = '_TW1'; break;
                 case 'tw2': $periodeText = '_TW2'; break;
                 case 'tw3': $periodeText = '_TW3'; break;
                 case 'tw4': $periodeText = '_TW4'; break;
             }
        }
        $divisiModel = $this->divisi ? Divisi::find($this->divisi) : null;
        $divisiText = Auth::user()->role === 'Admin' && $divisiModel ? str_replace(' ', '_', $divisiModel->nama) . '_' : (Auth::user()->role !== 'Admin' && Auth::user()->divisi ? str_replace(' ', '_', Auth::user()->divisi->nama) . '_' : '');
        
        $statusText = $this->status ? str_replace(' ', '_', $this->status) . '_' : 'SemuaStatus_';

        $fileName = 'Arsip_' . $divisiText . $statusText . $tahunText . $periodeText . '_' . now()->format('Ymd_His') . '.xlsx';
        $this->showExportModal = false;
        
        $statusForExport = ($this->status === $this->arsipDipindahStatus) ? $this->arsipDipindahStatus : $this->status;

        return Excel::download(new ArsipExport(
            $this->search,
            $statusForExport, 
            $this->divisi,
            $this->exportTahun,
            $this->exportPeriode,
            Auth::user()->role === 'Admin' ? null : Auth::user()->divisi_id
        ), $fileName);
    }

    /**
     * Aksi: Membuat Draf Usulan Pemusnahan
     */
    public function buatUsulanPemusnahan()
    {
        if (Auth::user()->role !== 'Admin') return;
        if (count($this->selectedArsip) === 0) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Anda belum memilih arsip untuk diusulkan musnah.']);
            return;
        }

        $validArsipIds = Arsip::whereIn('id', $this->selectedArsip)->where('status', 'Siap Dimusnahkan')->pluck('id');
        if ($validArsipIds->isEmpty()) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Tidak ada arsip berstatus "Siap Dimusnahkan" yang valid.']);
            return;
        }

        DB::beginTransaction();
        try {
            $usulan = UsulanPemusnahan::create([
                'nomor_usulan' => 'DRAFT-' . time(),
                'tanggal_usulan' => Carbon::now(),
                'status' => 'Draft',
                'created_by' => Auth::id(),
            ]);
            $nomor_formal = 'USUL/BBPOM/' . $usulan->id . '/' . date('Y');
            $usulan->nomor_usulan = $nomor_formal;
            $usulan->save();
            $usulan->arsips()->attach($validArsipIds);
            Arsip::whereIn('id', $validArsipIds)->update(['status' => 'Diusulkan Musnah']);
            DB::commit();
            
            $this->selectedArsip = [];
            $this->selectAll = false;
            
            $this->dispatchBrowserEvent('swal:redirect', [
                'url' => route('admin.usulan-pemusnahan.index'),
                'message' => 'Draft Usulan Pemusnahan berhasil dibuat.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Error!', 'text' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Aksi: Membuat Draf Usulan Pindah
     */
    public function buatUsulanPindah()
    {
        if (Auth::user()->role === 'Admin') {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Admin tidak bisa membuat Usulan Pindah.']);
            return;
        }
        if (count($this->selectedArsip) === 0) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Anda belum memilih arsip untuk diusulkan pindah.']);
            return;
        }

        $validArsip = Arsip::whereIn('id', $this->selectedArsip)
                             ->where('status', 'Inaktif') 
                             ->pluck('id');

        if (count($validArsip) !== count($this->selectedArsip)) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Hanya arsip dengan status "Inaktif" yang bisa diusulkan pindah.']);
            return;
        }

        DB::beginTransaction();
        try {
            $usulan = UsulanPindah::create([
                'user_id' => Auth::id(),
                'status' => 'Draft',
                'nomor_ba' => 'DRAFT-BA-' . time(), 
                'tanggal_ba' => Carbon::now(),
            ]);
            
            $usulan->arsips()->attach($validArsip);
            Arsip::whereIn('id', $validArsip)->update(['status' => 'Diusulkan Pindah']);

            DB::commit();
            
            $this->selectedArsip = [];
            $this->selectAll = false;
            
            $this->dispatchBrowserEvent('swal:redirect', [
                'url' => route('usul-pindah.index'),
                'message' => 'Draft Usulan Pindah berhasil dibuat. Silakan lengkapi Berita Acara dan ajukan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error', 'title' => 'Error!', 'text' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Render tampilan.
     */
    public function render()
    {
        $arsips = $this->arsipsQuery()->paginate(10);

        $baseQuery = Arsip::query(); 
        $baseQuery->when($this->createdBy, fn($q) => $q->where('created_by', $this->createdBy));

        $countArsipDipindah = 0;
        $allCounts = [];
        $this->statusCounts = [];

        if (Auth::user()->role !== 'Admin') {
            // LOGIKA ARSIPARIS
            $myDivisiId = Auth::user()->divisi_id;
            
            $countArsipDipindah = Arsip::withoutGlobalScope(DivisiScope::class) 
                                      ->where('divisi_id', $this->tataUsahaDivisiId)
                                      ->where('created_by', Auth::id())
                                      ->when($this->createdBy, fn($q) => $q->where('created_by', $this->createdBy))
                                      ->count();
            
            if (empty($this->status)) {
                 $baseQuery->whereNotIn('status', [
                     'Diusulkan Musnah', // Arsiparis tidak perlu lihat ini
                 ]);
            }

            $allCounts = $baseQuery->select('status', DB::raw('count(*) as count'))
                                  ->groupBy('status')->pluck('count', 'status')->toArray();

            $this->statusCounts = [
                'Aktif'             => $allCounts['Aktif'] ?? 0,
                'Inaktif'           => $allCounts['Inaktif'] ?? 0,
                'Diusulkan Pindah'  => $allCounts['Diusulkan Pindah'] ?? 0, 
                $this->arsipDipindahStatus => $countArsipDipindah, 
                'Siap Dimusnahkan'  => $allCounts['Siap Dimusnahkan'] ?? 0,
                'Permanen'          => $allCounts['Permanen'] ?? 0,
                'Musnah'            => $allCounts['Musnah'] ?? 0,
            ];
            
            $this->statusCounts['Semua'] = ($allCounts['Aktif'] ?? 0) + 
                                         ($allCounts['Inaktif'] ?? 0) + 
                                         ($allCounts['Diusulkan Pindah'] ?? 0) + 
                                         ($allCounts['Siap Dimusnahkan'] ?? 0) + 
                                         ($allCounts['Permanen'] ?? 0) + 
                                         ($allCounts['Musnah'] ?? 0);

        } else {
            // LOGIKA ADMIN
            if (Auth::user()->role === 'Admin' && $this->divisi) {
                $baseQuery->where('divisi_id', $this->divisi);
            }
            if (empty($this->status)) {
                 $baseQuery->whereNotIn('status', [
                     'Diusulkan Pindah', // Admin tidak perlu lihat ini (ada di halaman review)
                 ]);
            }

            $allCounts = $baseQuery->select('status', DB::raw('count(*) as count'))
                                  ->groupBy('status')->pluck('count', 'status')->toArray();

            $this->statusCounts = [
                'Aktif'             => $allCounts['Aktif'] ?? 0,
                'Inaktif'           => $allCounts['Inaktif'] ?? 0,
                'Siap Dimusnahkan'  => $allCounts['Siap Dimusnahkan'] ?? 0,
                'Diusulkan Musnah'  => $allCounts['Diusulkan Musnah'] ?? 0, 
                'Permanen'          => $allCounts['Permanen'] ?? 0, 
                'Musnah'            => $allCounts['Musnah'] ?? 0,
            ];
            $this->statusCounts['Semua'] = array_sum($this->statusCounts);
        }

        return view('livewire.arsip-table', [
            'arsips' => $arsips,
            'allDivisi' => Auth::user()->role === 'Admin'
                                    ? Divisi::where('id', '!=', 1)->orderBy('nama')->get()
                                    : collect(),
        ]);
    }
}