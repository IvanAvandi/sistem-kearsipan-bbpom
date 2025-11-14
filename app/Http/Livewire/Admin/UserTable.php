<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Divisi;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport; 

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterBidang = '';
    public $filterStatus = '';
    
    protected $paginationTheme = 'tailwind';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterBidang() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    /**
     * Query dasar untuk mengambil data pengguna.
     */
    private function getUsersQuery()
    {
        return User::with('divisi')
            ->where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterBidang, function($q) {
                $q->where('divisi_id', $this->filterBidang);
            })
            ->when($this->filterStatus, function($q) {
                $q->where('aktif', $this->filterStatus);
            })
            ->orderBy('name');
    }

    /**
     * Aksi untuk mengekspor data pengguna (BARU).
     */
    public function export()
    {
        // Ambil data yang sudah difilter (tanpa paginasi)
        $users = $this->getUsersQuery()->get();
        
        $fileName = 'Daftar_Pengguna_Kearsipan_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new UserExport($users), $fileName);
    }

    /**
     * Render tampilan.
     */
    public function render()
    {
        $allDivisi = Divisi::where('id', '!=', 1)->orderBy('nama')->get();
        $users = $this->getUsersQuery()->paginate(10);

        return view('livewire.admin.user-table', [
            'users' => $users,
            'allDivisi' => $allDivisi
        ]);
    }
}