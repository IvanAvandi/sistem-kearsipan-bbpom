<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\UsulanPindah;
use App\Models\Arsip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Carbon\Carbon;

class UsulanPindahTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    protected $paginationTheme = 'tailwind';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }

    public function render()
    {
        $query = UsulanPindah::with('user.divisi', 'arsips')
            ->withCount('arsips')
            ->when($this->search, function($q) {
                $q->where('nomor_ba', 'like', '%'.$this->search.'%')
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', '%'.$this->search.'%'));
            })
            // 1. Abaikan status 'Draft' secara default (ketika filter status kosong)
            ->when(empty($this->status), function($q) {
                 $q->whereNotIn('status', ['Draft']);
            })
            // 2. Terapkan filter status yang dipilih user
            ->when($this->status, function($q) {
                $q->where('status', $this->status);
            });

        $usulans = $query->latest()->paginate(10);

        return view('livewire.admin.usulan-pindah-table', [
            'usulans' => $usulans
        ]);
    }
}