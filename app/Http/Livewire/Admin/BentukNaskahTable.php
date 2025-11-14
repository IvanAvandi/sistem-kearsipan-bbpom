<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\BentukNaskah;
use Livewire\WithPagination;

class BentukNaskahTable extends Component
{
    use WithPagination;
    
    public $search = '';
    protected $paginationTheme = 'tailwind';
    public $sortBy = 'nama_bentuk_naskah'; 
    public $sortDirection = 'asc';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    public function delete($id)
    {
        $item = BentukNaskah::find($id);
        $item->delete();
        session()->flash('success', 'Bentuk Naskah berhasil dihapus.');
    }

    public function render()
    {
        $items = BentukNaskah::where('nama_bentuk_naskah', 'like', '%'.$this->search.'%')
            ->where('nama_bentuk_naskah', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection) 
            ->paginate(10);
            
        return view('livewire.admin.bentuk-naskah-table', compact('items'));
    }
}