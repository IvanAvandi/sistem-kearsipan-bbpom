<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\LinkTerkait;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class LinkTerkaitTable extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'tailwind';
    public $sortBy = 'nama';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $item = LinkTerkait::find($id);
        
        if ($item->path_icon && Storage::disk('public')->exists($item->path_icon)) {
            Storage::disk('public')->delete($item->path_icon);
        }

        $item->delete();
        session()->flash('success', 'Link Terkait berhasil dihapus.');
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

    public function render()
    {
        $items = LinkTerkait::where('nama', 'like', '%'.$this->search.'%')
            ->orWhere('link_url', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->orderBy('nama', 'asc')
            ->paginate(10);

        return view('livewire.admin.link-terkait-table', compact('items'));
    }
}